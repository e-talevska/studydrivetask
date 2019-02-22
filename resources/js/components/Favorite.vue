<template>
    <div class="click" :class="{ 'active': isActive, 'active-2': isActive2, 'active-3': isActive3 }" >
        <span @click.prevent="toggleFavourite(image)" class="fa" :class="fullStar"></span>
        <div class="ring"></div>
        <div class="ring2"></div>
    </div>
</template>
<style>
    .click {
        font-size: 33px;
        color: rgba(0,0,0,.5);
        width: 38px;
        height: 38px;
        margin: 0 auto;
        position: relative;
        cursor: pointer;
    }

    .click span {
        margin-left: 4px;
        margin-top: 3px;
        z-index: 999;
        position: absolute;
    }

    span:hover {
        opacity: 0.8;
    }

    span:active {
        transform: scale(0.93,0.93) translateY(2px)
    }

    .ring, .ring2 {
        opacity: 0;
        background: grey;
        width: 1px;
        height: 1px;
        position: absolute;
        top: 19px;
        left: 18px;
        border-radius: 50%;
        cursor: pointer;
    }

    .active span, .active-2 span {
        color: #F5CC27 !important;
    }

    .active-2 .ring {
        width: 58px !important;
        height: 58px !important;
        top: -10px !important;
        left: -10px !important;
        position: absolute;
        border-radius: 50%;
        opacity: 1 !important;
    }

    .active-2 .ring {
        background: #F5CC27 !important;
    }

    .active-2 .ring2 {
        background: #fff !important;
    }

    .active-3 .ring2 {
        width: 60px !important;
        height: 60px !important;
        top: -11px !important;
        left: -11px !important;
        position: absolute;
        border-radius: 50%;
        opacity: 1 !important;
    }

    * {
        transition: all .32s ease;
    }
</style>
<script>
    import { checkResponse, post, put, remove } from "../helpers/http"
    export default {
        props: ['image', 'favourited'],
        data: function() {
            return {
                isFavourited: false,
                isActive: '',
                isActive2: '',
                isActive3: '',
                fullStar: 'fa-star-o'
            }
        },
        mounted() {
            this.calculateData();
        },
        computed: {
            isFavorite() {
                return this.favourited;
            },
        },
        watch: {
            'favourited': function () {
                console.log('called');
                this.calculateData();
            },
        },
        methods: {
            calculateData() {
                this.isFavourited = this.isFavorite ? true : false;
                this.isActive = this.isFavourited ? true : false;
                this.isActive2 = this.isFavourited ? true : false;
                this.isActive3 = this.isFavourited ? true : false;
                this.fullStar = this.isFavourited ? 'fa-star' : 'fa-star-o';
            },
            toggleFavourite(image) {
                this.isActive = !this.isActive;

                setTimeout(() => {
                    this.isActive2 = !this.isActive2;
                }, 30)

                this.isActive3 = !this.isActive3;

                this.isFavourited ? this.unFavorite(image) : this.favorite(image);
            },
            favorite(image) {
                    post(`/api/favourite`,{
                        image_id: this.image
                    })
                    .then(response => {
                        this.isFavourited = true;
                        this.fullStar = 'fa-star'
                    })
                    .catch(checkResponse)
            },
            unFavorite(image) {
                    remove(`/api/favourite/${image}`)
                    .then(response => {
                        this.isFavourited = false;
                        this.fullStar = 'fa-star-o'
                    })
                    .catch(checkResponse)
            }
        }
    }
</script>