<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="alert alert-danger" role="alert" v-if="error !== null">
                    {{ error }}
                </div>

                <div class="card card-default">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form @submit.prevent="handleSubmit">
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" v-model="email" required>
                                    <div v-if="!validateEmail()" class="text-danger">Enter a valid email address</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="password" required>
                                    <div v-if="!validatePassword()" class="text-danger">Password is required</div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" :disabled="!isFormValid">
                                        Login
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    data() {
        return {
            email: "",
            password: "",
            error: null,
        };
    },
    methods: {
        validateEmail() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(this.email);
        },
        validatePassword() {
            return this.password.trim() !== "";
        },
        handleSubmit() {
            if (!this.validateEmail() || !this.validatePassword()) {
                console.log("Form is invalid");
                return;
            }

            // Continue with form submission logic
                this.$axios
                    .post("/api/login", {
                        email: this.email,
                        password: this.password,
                    })
                    .then((response) => {
                        console.log(response.data);
                        if (response.data.success) {
                            console.log('Response in success login component',response);
                            this.$store.dispatch('login', response.data.token);
                            localStorage.setItem('token', response.data.token);
                            this.$router.push('/dashboard');
                        } else {

                            this.error = response.data.error;
                            console.log(this.error);

                        }
                    })
                    .catch((error) => {
                        console.error(error);
                    });
        },
    },
    computed: {
        ...mapGetters(['isLoggedIn']),
        isFormValid() {
            return this.validateEmail() && this.validatePassword();
        },
    },
    watch: {
        isLoggedIn(newVal) {
            console.log('isLoggedIn state has changed in login component:', newVal);
            // Take action based on the new value
        }
    }
};
</script>
