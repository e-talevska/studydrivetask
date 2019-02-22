<template>
    <div class="container">
        <ListItems :offset="3" :items="items" :pagination="pagination" @fetchItems="fetchItems"></ListItems>
    </div>
</template>
<script>
    import { checkResponse, get } from "../helpers/http"
    export default {
        data(){
            return {
                items: [],
                pagination: {
                    'current_page': 1,
                    'offset': 30,
                },
                favourites: [],
            }
        },
        mounted() {
            this.fetchItems()
        },
        methods : {
            fetchItems() {
                return get(`/api/favourite?page=${this.pagination.current_page}&limit=${this.pagination.offset}`)
                    .then(response => {
                        this.items = response.data.data;
                        this.pagination.current_page = response.data.current_page;
                        this.pagination.last_page = response.data.last_page;
                    })
                    .catch(checkResponse)
            },
        },
        beforeRouteEnter (to, from, next) {
            if (localStorage.getItem('jwt')) {
                return next('listimages')
            }

            next();
        },
    }
</script>