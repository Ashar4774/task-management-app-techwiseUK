<template>
    <div>
        <h2>Edit Task</h2>
        <form @submit.prevent="updateTask">
            <!-- Task details form fields -->
            <label for="title">Title:</label>
            <input type="text" id="title" v-model="editedTask.title" required>
            <label for="dueDate">Due Date:</label>
            <input type="date" id="dueDate" v-model="editedTask.due_date" required>
            <label for="description">Description:</label>
            <textarea id="description" v-model="editedTask.description"></textarea>
            <label for="priority">Priority:</label>
            <select id="priority" v-model="editedTask.priority" required>
                <option value="1">Low</option>
                <option value="2">Medium</option>
                <option value="3">High</option>
            </select>
            <!-- Submit button -->
            <button type="submit">Update Task</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import { ref } from 'vue';
import { mapGetters } from 'vuex';

export default {
    props: ['taskId'],
    data() {
        return {
            editedTask: {
                title: '',
                due_date: '',
                description: '',
                priority: '',
            },
        };
    },
    async mounted() {
        await this.fetchTaskDetails();
    },
    methods: {
        async fetchTaskDetails() {
            try {
                const response = await axios.get(`/api/task/task_show/${this.taskId}`, {
                    headers: { Authorization: `Bearer ${this.token}` }
                });
                this.editedTask = response.data;
            } catch (error) {
                console.error('Error fetching task details:', error);
            }
        },
        async updateTask() {
            try {
                const response = await axios.put(`/api/task/task_update/${this.taskId}`, this.editedTask, {
                    headers: { Authorization: `Bearer ${this.token}` }
                });
                console.log('Task updated:', response.data);

                // Redirect to task list route
                this.$router.push({ name: 'task-list' });
            } catch (error) {
                console.error('Error updating task:', error);
            }
        },
    },
    computed: {
        ...mapGetters(['token'])
    }
};
</script>

<style>
h2 {
    margin-bottom: 20px;
    font-size: 24px;
}

form {
    max-width: 400px;
    margin: auto;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
input[type="date"],
textarea,
select {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}
</style>

