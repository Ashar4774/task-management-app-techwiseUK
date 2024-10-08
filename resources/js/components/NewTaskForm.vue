<template>
    <form @submit.prevent="addTask" class="task-form">
        <label htmlFor="title">Title:</label>
        <input type="text" id="title" v-model="title" required>
        <label htmlFor="dueDate">Due Date:</label>
        <input type="date" id="dueDate" v-model="dueDate" required>
        <label htmlFor="description">Description:</label>
        <textarea id="description" v-model="description"></textarea>
        <label htmlFor="priority">Priority:</label>
        <select id="priority" v-model="priority" required>
            <option value="1">Low</option>
            <option value="2">Medium</option>
            <option value="3">High</option>
        </select>
        <button type="submit">Add Task</button>
    </form>
</template>

<script>
import axios from 'axios';
import {mapGetters} from 'vuex';

export default {
    data() {
        return {
            title: "",
            dueDate: "",
            description: "",
            priority: "",
            user_id: 1
        };
    },
    methods: {
        addTask() {
            // Create new task object
            const newTask = {
                title: this.title,
                due_date: this.dueDate,
                description: this.description,
                priority: parseInt(this.priority),
                user_id: this.user_id
            };

            // Make API call to store new task
            axios.post('/api/task/task_store', newTask, {
                headers: {Authorization: `Bearer ${this.token}`}
            })
                .then(response => {
                    // Redirect to task_list route after adding task
                    this.$router.push('/task/list');
                })
                .catch(error => {
                    console.error('Error adding task:', error);
                });
        },
    },
    computed: {
        ...mapGetters(['token'])
    }
};
</script>

<style scoped>
.task-form {
    display: flex;
    flex-direction: column;
    width: 300px;
    margin: auto;
}

label {
    margin-bottom: 5px;
}

input, select, textarea, button {
    margin-bottom: 10px;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    background-color: #007bff;
    color: #fff;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}
</style>
