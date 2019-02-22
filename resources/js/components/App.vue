<template>
    <div>
        <!--<rotate-square2 v-if="spinnerVisible"></rotate-square2>-->
        <div v-if="spinnerVisible" class="spinner"></div>
        <div :class="{'overlay':spinnerVisible}">
            <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
                <div class="container">
                    <router-link :to="{name: 'home'}" class="navbar-brand">StudydriveTest</router-link>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto"></ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->

                            <router-link :to="{ name: 'login' }" class="nav-link" v-if="!isLoggedIn">Login</router-link>
                            <router-link :to="{ name: 'register' }" class="nav-link" v-if="!isLoggedIn">Register</router-link>
                            <li class="nav-link" v-if="isLoggedIn"> Hi, {{name}}</li>
                            <router-link :to="{ name: 'listimages' }" class="nav-link" v-if="isLoggedIn">Images</router-link>
                            <router-link :to="{ name: 'login' }" @click.native="logout()" class="nav-link" v-if="isLoggedIn">Log out</router-link>
                        </ul>
                    </div>
                </div>
            </nav>
            <main class="py-4">
                <router-view></router-view>
            </main>
        </div>
    </div>
</template>
<style>
    .overlay {
        position: fixed;
        width: 100%;
        height: 100%;
        opacity: .5;
    }

    .spinner {
        position: absolute;
        left: 50%;
        top: 50%;
        height:60px;
        width:60px;
        margin:0px auto;
        -webkit-animation: rotation .6s infinite linear;
        -moz-animation: rotation .6s infinite linear;
        -o-animation: rotation .6s infinite linear;
        animation: rotation .6s infinite linear;
        border-left:6px solid rgba(0,174,239,.15);
        border-right:6px solid rgba(0,174,239,.15);
        border-bottom:6px solid rgba(0,174,239,.15);
        border-top:6px solid rgba(0,174,239,.8);
        border-radius:100%;
    }

    @-webkit-keyframes rotation {
        from {-webkit-transform: rotate(0deg);}
        to {-webkit-transform: rotate(359deg);}
    }
    @-moz-keyframes rotation {
        from {-moz-transform: rotate(0deg);}
        to {-moz-transform: rotate(359deg);}
    }
    @-o-keyframes rotation {
        from {-o-transform: rotate(0deg);}
        to {-o-transform: rotate(359deg);}
    }
    @keyframes rotation {
        from {transform: rotate(0deg);}
        to {transform: rotate(359deg);}
    }
</style>
<script>
    // import {RotateSquare2} from 'vue-loading-spinner'
    import { eventHub } from '../helpers/eventhub'
    export default {
        data() {
            return {
                isLoggedIn : null,
                name : null,
                spinnerVisible: false
            }
        },
        mounted() {
            this.isLoggedIn = localStorage.getItem('jwt');
            this.name = localStorage.getItem('user');
        },
        methods: {
            logout(){
                let token = localStorage.getItem('jwt');

                axios.defaults.headers.common['Content-Type'] = 'application/json';
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;

                axios.post('api/logout')
                .then(response => {
                    localStorage.removeItem('user');
                    localStorage.removeItem('jwt');

                    this.$router.go('/login')
                })
                .catch(error => {
                    console.error(error);
                });
            },
            showSpinner(e) {
                this.spinnerVisible = true;
            },
            hideSpinner(e) {
                this.spinnerVisible = false;
            }
        },
        created() {
            eventHub.$on('before-request', this.showSpinner);
            eventHub.$on('request-error',  this.hideSpinner);
            eventHub.$on('after-response', this.hideSpinner);
            eventHub.$on('response-error', this.hideSpinner);
        },
        beforeDestroy() {
            eventHub.$off('before-request', this.showSpinner);
            eventHub.$off('request-error',  this.hideSpinner);
            eventHub.$off('after-response', this.hideSpinner);
            eventHub.$off('response-error', this.hideSpinner);
        }
    }
</script>