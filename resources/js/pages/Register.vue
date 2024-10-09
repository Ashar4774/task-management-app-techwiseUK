<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="alert alert-danger" role="alert" v-if="error !== null">
                    {{ error }}
                </div>

                <div class="card card-default">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form @submit.prevent="handleSubmit">
                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" v-model="name" required>
                                    <div v-if="!validateName()" class="text-danger">Name is required</div>
                                </div>
                            </div>

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
                                        Register
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
export default {
    data() {
        return {
            name: "",
            email: "",
            password: "",
            error: null,
        };
    },
    methods: {
        validateName() {
            return this.name.trim() !== "";
        },
        validateEmail() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(this.email);
        },
        validatePassword() {
            return this.password.trim() !== "";
        },
        handleSubmit() {
            if (!this.validateName() || !this.validateEmail() || !this.validatePassword()) {
                console.log("Form is invalid");
                return;
            }

            // Continue with form submission logic
                axios
                    .post("api/register", {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                    })
                    .then((response) => {
                        if (response.data.success) {
                            this.$store.dispatch('login', response.data.token);
                            localStorage.setItem('token', response.data.token);
                            this.$router.push('/login');
                            //window.location.href = "/login";
                        } else {
                            this.error = response.data.message;
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
        },
    },
    computed: {
        isFormValid() {
            return this.validateName() && this.validateEmail() && this.validatePassword();
        },
    },
};
</script>
