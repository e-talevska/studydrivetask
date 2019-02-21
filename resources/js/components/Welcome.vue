<style scoped>
    .full-height {
        height: 100vh;
    }
    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }
    .position-ref {
        position: relative;
    }
    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
    }
    .content {
        text-align: center;
    }
    .title {
        font-size: 60px;
    }
    .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }
    .m-b-md {
        margin-bottom: 30px;
        color: #000000;
    }
</style>
<template>
    <div class="container">
        <div class="row justify-content-center">
            <draggable element="div" class="col-md-12" v-model="images">
                <transition-group class="row">
                    <div class="col-md-4" v-for="element,index in images" :key="element.id">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{element.name}}</h4>
                            </div>
                            <div class="card-body card-body-dark">
                                <transition-group :id="element.id">
                                    <div v-for="task,index in element.tasks" :key="task.category_id+','+task.order" class="transit-1" :id="task.id">
                                        <div class="small-card">
                                            <textarea v-if="task === editingTask" class="text-input" @keyup.enter="endEditing(task)" @blur="endEditing(task)" v-model="task.name"></textarea>
                                            <label for="checkbox" v-if="task !== editingTask" @dblclick="editTask(task)">{{ task.name }}</label>
                                        </div>
                                    </div>
                                </transition-group>
                                <div class="small-card">
                                    <h5 class="text-center" @click="addNew(index)">Add new card</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition-group>
            </draggable>
        </div>
    </div>
</template>
<script>
    export default {

    }
</script>