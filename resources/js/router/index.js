import {createWebHistory, createRouter} from "vue-router";

import Home from '../pages/Home';
import About from '../pages/About';
import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';
import TaskScheduler from "../components/TaskScheduler.vue";
import NewTaskForm from "../components/NewTaskForm.vue";
import EditTask from "../components/EditTask.vue";
import store from "../state/store.js"

export const routes = [
    // {
    //     name: 'home',
    //     path: '/',
    //     component: Home
    // },
    {
        name: 'about',
        path: '/about',
        component: About
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
      path: '/',
      redirect:() => {
            const isAuthenticated = store.getters.isAuthenticated;
            return isAuthenticated ? '/dashboard' : '/login'
      },
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },
    {
        path: '/task/form',
        component: NewTaskForm,
        name: 'task-form'
    },
    {
        path: '/task/list',
        component: TaskScheduler,
        name: 'task-list'
    },
    {
        path: '/task/:taskId/edit',
        name: 'task.edit',
        component: EditTask,
        props: true,
    },

];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = store.getters.isLoggedIn; // Check Vuex state

    if (to.meta.requiresAuth && !isAuthenticated) {
        next({ name: 'login' }); // Redirect to login if not authenticated
    } else if (to.meta.requiresGuest && isAuthenticated) {
        next({ name: 'dashboard' }); // Redirect to dashboard if already authenticated
    } else {
        next(); // Proceed to the route
    }
});
export default router;
