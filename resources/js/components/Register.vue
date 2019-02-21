<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Register</div>

                    <div class="card-body">
                        <form method="POST" @submit.prevent="submit">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6" :class="{ 'form-group--error': $v.name.$error }">
                                    <input id="name" type="text" class="form-control" v-model.trim="$v.name.$model" required autofocus>
                                    <div class="error" v-if="!$v.name.required">Name is required</div>
                                    <div class="error" v-if="!$v.name.minLength">Name must have at least {{$v.name.$params.minLength.min}} letters.</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6" :class="{ 'form-group--error': $v.email.$error }">
                                    <input id="email" type="email" class="form-control" v-model.trim="$v.email.$model" required>
                                    <div class="error" v-if="!$v.email.required">Email is required</div>
                                    <div class="error" v-if="!$v.email.email">Please provide valid email</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6" :class="{ 'form-group--error': $v.password.$error }">
                                    <input id="password" type="password" class="form-control" v-model="$v.password.$model" required>
                                    <div class="error" v-if="!$v.password.required">Password is required</div>
                                    <div class="error" v-if="!$v.password.minLength">Password must have at least {{$v.password.$params.minLength.min}} letters.</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                                <div class="col-md-6" :class="{ 'form-group--error': $v.password_confirmation.$error }">
                                    <input id="password-confirm" type="password" class="form-control" v-model="$v.password_confirmation.$model" required>
                                    <div class="error" v-if="!$v.password_confirmation.required">Password is required</div>
                                    <div class="error" v-if="!$v.password_confirmation.minLength">Password must have at least {{$v.password.$params.minLength.min}} letters.</div>
                                    <div class="error" v-if="!$v.password_confirmation.sameAsPassword"> Passwords must be identical</div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary" @click="handleSubmit">
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
    import { required, minLength, sameAs, email } from 'vuelidate/lib/validators'

    export default {
        data(){
            return {
                name : "",
                email : "",
                password : "",
                password_confirmation : "",
                errors: [],
            }
        },
        validations: {
            name: {
                required,
                minLength: minLength(4)
            },
            password: {
                required,
                minLength: minLength(6)
            },
            password_confirmation: {
                required,
                minLength: minLength(6),
                sameAsPassword: sameAs('password')
            },
            email: {
                required,
                email,
                async isUnique (value) {
                    if (value === '') return true;
                    const response = await fetch(`/api/user/${value}`)
                    return Boolean(await response.json())
                }
            },
        },
        methods : {
            handleSubmit(e) {
                e.preventDefault();
                this.$v.$touch();
                if (!this.$v.$invalid) {
                    axios.post('api/register', {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        c_password : this.password_confirmation
                    })
                    .then(response => {
                        localStorage.setItem('user',response.data.success.name)
                        localStorage.setItem('jwt',response.data.success.token)

                        if (localStorage.getItem('jwt') != null){
                            this.$router.go('/board')
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
                }
            },
            validEmail: function (email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }
        },
        beforeRouteEnter (to, from, next) {
            if (localStorage.getItem('jwt')) {
                return next('board');
            }

            next();
        }
    }
</script>