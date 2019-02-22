<template>
    <div class="container">
        <ListItems :offset="3" :items="images" :pagination="pagination" :favourites="favourites" @fetchItems="fetchItems"></ListItems>
    </div>
</template>
<script>
    import { checkResponse, get } from "../helpers/http"
    let total = 5000;
    let offset = 30;
    export default {
        data(){
            return {
                images: [],
                pagination: {
                    'current_page': 1,
                    'offset': 30,
                    'last_page': total%offset ? parseInt(total/offset) + 1 : parseInt(total/offset)
                },
                favourites: [],
            }
        },
        mounted() {
            this.fetchItems(),
            this.favouriteImages()
        },
        methods : {
            fetchItems() {
                axios.get("https://jsonplaceholder.typicode.com/photos?_page=" + this.pagination.current_page + "&_limit="+ this.pagination.offset).then(result => {
                    this.images = result.data;
                }, error => {
                    console.error(error);
                });
            },
            favouriteImages() {
                return get('/api/user/favourites')
                    .then(response => this.favourites = response.data)
                    .catch(checkResponse)
            },
        },
        beforeRouteEnter (to, from, next) {
            if ( ! localStorage.getItem('jwt')) {
                return next('login')
            }

            next();
        },
    }
</script>