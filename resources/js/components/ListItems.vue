<template>
    <div>
        <div class="col-sm-12" v-model="items" >
                <silentbox-group>
                    <div :class="{'col-sm-5 col-md-3 col-lg-2 box': item.url}" v-for="(item,index) in items" :key="item.id" :description="item.title">
                        <div v-if="item.thumbnailUrl">
                            <silentbox-item :src="item.url" >
                                <figure
                                        itemprop="associatedMedia"
                                        itemscope
                                        itemtype="http://schema.org/ImageObject"
                                        :src="item.url"
                                        v-bind:key="index">
                                            <img :src="item.thumbnailUrl" :alt="item.title" itemprop="thumbnail"/>
                                </figure>
                            </silentbox-item>
                            <div v-if="favourites" class="favourite">
                                <Favourite
                                        :image="item.id"
                                        :favourited="favourited(item.id)"
                                ></Favourite>
                            </div>
                        </div>
                        <div v-if="item.name">
                            <ul class="list-group">
                                <li class="list-group-item" v-text="item.name"></li>
                            </ul>
                        </div>
                    </div>
                </silentbox-group>
        </div>
        <pagination v-if="pagination.last_page > 1" :offset="offset" :pagination="pagination" @paginate="fetchItems()"></pagination>
    </div>
</template>
<style>
    figure {
        position: relative;
    }

    .favourite {
        position: absolute;
        bottom: 0%;
    }

    .box {
        display: inline-block;

    }
</style>
<script>
    export default {
        props: ['items', 'offset', 'favourites', 'pagination'],
        data(){
            return {
            }
        },
        methods : {
            fetchItems(page) {
                this.$emit('fetchItems', page);
            },
            favourited(id) {
                return this.favourites && this.favourites.indexOf(id) !== -1;
            },
        }
    }
</script>