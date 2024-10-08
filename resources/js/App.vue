<template>
    <div class="container">
        <div class="text-center" style="margin: 20px 0px 20px 0px;">
            <a href="#" target="_blank"><img src="https://images.unsplash.com/photo-1532622785990-d2c36a76f5a6?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8ZmVlZGJhY2slMjBtb2R1bGV8ZW58MHx8MHx8fDA%3D" class="img_shad" ></a><br>
            <span class="text-secondary">Task Module</span>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <!-- for logged-in user-->
                <div class="navbar-nav" v-if="isLoggedIn">
                    <router-link to="/dashboard" class="nav-item nav-link">Dashboard</router-link>
                    <router-link to="/task/list" class="nav-item nav-link">Tasks</router-link>
                    <a class="nav-item nav-link" style="cursor: pointer;" @click="logout">Logout</a>
                </div>
                <!-- for non-logged user-->
                <div class="navbar-nav" v-else>
                    <!-- <router-link to="/" class="nav-item nav-link">Home</router-link> -->
                    <router-link to="/login" class="nav-item nav-link">Login</router-link>
                    <router-link to="/register" class="nav-item nav-link">Register</router-link>
                    <!-- <router-link to="/about" class="nav-item nav-link">About</router-link> -->
                </div>
            </div>
        </nav>
        <br/>
        <router-view/>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    name: "App",
    // data() {
    //     return {
    //         isLoggedIn: false,
    //     }
    // },
    created() {
        // Check if token exists in localStorage
        // const token = localStorage.getItem('token');

    },
    computed: {
        ...mapGetters(['isLoggedIn']),
        ...mapGetters(['token']),
        ...mapGetters(['user'])
    },
    methods: {
        logout() {
            localStorage.removeItem('token'); // Remove token from localStorage
            this.$store.dispatch('logout');
            // this.isLoggedIn = false; // Set isLoggedIn to false
            this.$router.push('/login'); // Redirect to login page
        }
    },
    watch: {
        isLoggedIn(newVal) {
            console.log('isLoggedIn state has changed:', newVal);
            // Take action based on the new value
        }
    }
}
</script>
<style scoped>
.img_shad {
    /* vertical-align: middle; */
    /* border-style: none; */
    /* width: 150px; */
    /* height: auto; */
    /* vertical-align: 1px; */
    margin: auto;
    width: 102px;
    height: 102px;
    /* border-radius: 150px; */
    -webkit-border-radius: 109px;
    -moz-border-radius: 150px;
    background: url(https://i.stack.imgur.com/S1ZCs.jpg) no-repeat;
}
</style>
