<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12" v-model="images">
                <transition-group class="row">
                    <div class="col-md-4" v-for="element,index in images" :key="element.id">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{element.title}}</h4>
                            </div>
                            <div class="card-body card-body-dark">
                                <img :src="element.thumbnailUrl" alt="">
                                <div class="small-card">
                                    <h5 class="text-center" @click="addNew(index)">Add new card</h5>
                                    <form method="POST" action="/login">
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>

                                            <div class="col-md-6">
                                                <input id="email" type="email" class="form-control" v-model="email" required autofocus>
                                            </div>
                                        </div>


                                        <div class="form-group row mb-0">
                                            <div class="col-md-8 offset-md-4">
                                                <button type="submit" class="btn btn-primary" @click="handleSubmit">
                                                    Login
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition-group>
            </div>
            <pagination v-if="pagination.last_page > 1" :pagination="pagination" @paginate="fetchImages()"></pagination>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                images: [],
                image_id: null,
                pagination: {
                    'current_page': 1
                }
            }
        },
        mounted() {
            this.fetchImages()
        },
        methods : {
            fetchImages() {
                this.$http.get("https://jsonplaceholder.typicode.com/photos?_page=" + this.pagination.current_page + "&_limit=50").then(result => {
                    this.images = result.body;
                    this.pagination.current_page++;
                }, error => {
                    console.error(error);
                });
            },
            handleSubmit(e){
                e.preventDefault()

                if (this.password.length > 0) {
                    let token = localStorage.getItem('jwt');

                    axios.defaults.headers.common['Content-Type'] = 'application/json';
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;

                    axios.post('api/login', {
                        image_id: this.image_id
                    })
                    .then(response => {
                        localStorage.setItem('user',response.data.success.name)
                        localStorage.setItem('jwt',response.data.success.token)

                        if (localStorage.getItem('jwt') != null){
                            this.$router.go('/board')
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
                }
            }
        },
        beforeRouteEnter (to, from, next) {
            if ( ! localStorage.getItem('jwt')) {
                return next('login')
            }

            next();
        }
    }
</script>