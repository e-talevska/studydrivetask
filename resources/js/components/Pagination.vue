<template>
    <nav role="navigation" aria-label="pagination">
        <ul class="pagination justify-content-center">
            <li class="page-item" :class="{'disabled' : pagination.current_page <= 1}"><a href="#" class="page-link pagination-previous" @click.prevent="changePage(1)" :disabled="pagination.current_page <= 1">First page</a></li>
            <li class="page-item" :class="{'disabled' : pagination.current_page <= 1}"><a href="#" class="page-link pagination-previous" @click.prevent="changePage(pagination.current_page - 1)" :disabled="pagination.current_page <= 1">Previous</a></li>
            <li class="page-item" v-for="page in pages" :class="isCurrentPage(page) ? 'active' : ''">
                <a href="#" class="page-link pagination-link" @click.prevent="changePage(page)">{{ page }}</a>
            </li>
            <li class="page-item" :class="{'disabled' : pagination.current_page >= pagination.last_page}"><a href="#" class="page-link pagination-next" @click.prevent="changePage(pagination.current_page + 1)" :disabled="pagination.current_page >= pagination.last_page">Next page</a></li>
            <li class="page-item" :class="{'disabled' : pagination.current_page >= pagination.last_page}"><a href="#" class="page-link pagination-next" @click.prevent="changePage(pagination.last_page)" :disabled="pagination.current_page >= pagination.last_page">Last page</a></li>
        </ul>
    </nav>
</template>

<style>
    .pagination {
        margin-top: 40px;
    }
</style>

<script>
    export default {
        props: ['pagination', 'offset'],

        methods: {
            isCurrentPage(page) {
                return this.pagination.current_page === page;
            },

            changePage(page) {
                if (page > this.pagination.last_page) {
                    page = this.pagination.last_page;
                }

                this.pagination.current_page = page;
                this.$emit('paginate');
            }
        },

        computed: {
            pages() {
                let pages = [];

                let from = this.pagination.current_page - Math.floor(this.offset / 2);

                if (from < 1) {
                    from = 1;
                }

                let to = from + this.offset - 1;

                if (to > this.pagination.last_page) {
                    to = this.pagination.last_page;

                    while (to - from <= this.offset) {
                        if (from > 1) {
                            from--;
                        } else {
                            break;
                        }
                    }
                }

                while (from <= to) {
                    pages.push(from);
                    from++;
                }

                return pages;
            }
        }
    }
</script>