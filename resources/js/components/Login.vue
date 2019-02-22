<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form method="POST" @submit.prevent="handleSubmit">
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" v-model="email" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6" :class="{ 'form-group--error': $v.password.$error || errors }">
                                    <input id="password" type="password" class="form-control" v-model="$v.password.$model" required>
                                    <div class="error" v-if="!$v.password.required">Password is required</div>
                                    <div class="error" v-if="errors">Wrong username or password</div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
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
    import { required } from 'vuelidate/lib/validators'
    export default {
        data(){
            return {
                email : "",
                password : "",
                errors: false
            }
        },
        validations: {
            password: {
                required,
            },
        },
        methods : {
            handleSubmit(e){
                e.preventDefault();
                this.errors = false;

                this.$v.$touch();

                if (!this.$v.$invalid) {
                    axios.post('api/login', {
                        email: this.email,
                        password: this.password
                    })
                        .then(response => {
                            localStorage.setItem('user',response.data.success.name);
                            localStorage.setItem('jwt',response.data.success.token);

                            if (localStorage.getItem('jwt') != null){
                                this.$router.go('/listimages')
                            }
                        })
                        .catch(error => {
                            this.errors = true;
                            // console.error(error);
                        });
                }
            }
        },
        beforeRouteEnter (to, from, next) {
            if (localStorage.getItem('jwt')) {
                return next('listimages');
            }

            next();
        }
    }
</script>