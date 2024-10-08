<template>
    <div className="dashboard">
        <h2>Welcome, {{ user.name }}</h2>
        <!-- Additional dashboard content can be added here -->
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
    name: "Dashboard",
    props: {
        name: {
            type: String,
            required: true
        }
    },
    computed: {
        ...mapGetters(['user'])
    },
    watch: {
        user(auth) {
            console.log("Logged in user is :", auth);
        }
    }
};
</script>

<style scoped>
.dashboard {
    text-align: center;
    padding: 20px;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    border-radius: 5px;
}
</style>
