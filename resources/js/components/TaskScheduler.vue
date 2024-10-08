<template>
    <div>
        <div class="feedback-header">
            <router-link to="/task/form" class="add-task-btn">
                Add Task
            </router-link>
        </div>
        <h1>Task Scheduler</h1>
        <div v-if="tasks.length > 0">
            <!-- <ul>
                <li v-for="task in tasks" :key="task.id" class="task-item" @click="showTaskDetails(task)">
                    {{ task.title }} - {{ task.due_date }}
                </li>
            </ul> -->

            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4" v-for="task in tasks" :key="task.id" @click="showTaskDetails(task)">
                        <!-- Card to display each task -->
                        <div class="card mr-1">
                            <div class="card-body">
                                <h5 class="card-title">{{ task.title }}</h5>
                                <p class="card-text">{{ task.due_date }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <p>No tasks available.</p>
        </div>
        <div v-if="selectedTask">
            <div class="container mt-2">
                <div class="card p-3">
                    <h2>Task Details</h2>
                    <p>Title: {{ selectedTask.title }}</p>
                    <p>Due Date: {{ selectedTask.due_date }}</p>
                    <p>Description: {{ selectedTask.description }}</p>
                    <p>Priority: {{ priorityLabel }}</p>
                    <div class="d-flex flex-row">
                        <button class="edit-btn" @click="editTask">Edit Task</button>
                        <button class="delete-btn" @click="deleteTask">Delete Task</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { useRouter } from 'vue-router';
import {mapGetters} from 'vuex';

export default {
    data() {
        return {
            tasks: [],
            selectedTask: null,
        };
    },
    mounted() {
        this.fetchTasks();
    },
    methods: {
        fetchTasks() {
            // const token = localStorage.getItem('token');

                axios.get("/api/task/task_list", {
                    headers: { Authorization: `Bearer ${this.token}` }
                })
                    .then(response => {
                        console.log(response.data);
                        this.tasks = response.data;
                    })
                    .catch(error => {
                        console.error("Error fetching tasks:", error);
                    });
        },
        showTaskDetails(task) {
            this.selectedTask = task;
        },
        editTask() {
            if (this.selectedTask) {
                const taskId = this.selectedTask.id;
                // Redirect to the edit page for the selected task
                this.$router.push({ name: 'task.edit', params: { taskId } });
            }
        },
        deleteTask() {
            if (this.selectedTask) {
                const taskId = this.selectedTask.id;
                axios.delete(`/api/task/task_destroy/${taskId}`)
                    .then(response => {
                        console.log('Task deleted:', response.data);
                        // After successful deletion, update the task list
                        this.fetchTasks();
                        // Clear the selectedTask to hide task details
                        this.selectedTask = null;
                    })
                    .catch(error => {
                        console.error("Error deleting task:", error);
                    });
            }
        },
    },
    computed: {
        ...mapGetters(['token'])
    },
    watch: {
        token(newVal) {
            console.log('token in TaskSchedular file is:', newVal);
            // Take action based on the new value
        }
    }
};
</script>


<style scoped>
.feedback-header {
    margin-bottom: 20px;
}

.add-task-btn {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.add-task-btn:hover {
    background-color: #0056b3;
}

.task-item {
    cursor: pointer;
    margin-bottom: 5px;
    background-color: #f0f0f0;
    padding: 10px;
}

.edit-btn, .delete-btn {
    margin-top: 10px;
    padding: 8px 12px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    color: #fff;
}

.edit-btn {
    background-color: #007bff;
}

.delete-btn {
    background-color: #dc3545;
}

.edit-btn:hover, .delete-btn:hover {
    opacity: 0.8;
}
</style>
