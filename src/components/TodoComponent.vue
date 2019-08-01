<template>
    <div class="todo">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="row">
                    <div class="col">
                        <h2>Todo List</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="input-group mb-3">
                            <input v-model="todoText" type="text" class="form-control" placeholder="할일 입력">
                            <div class="input-group-append">
                                <button @click="add" class="btn btn-outline-secondary" type="button">
                                    추가
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <transition-group class="list-group" tag="ul" name="todo">
                            <li class="list-group-item" v-for="item in list" :key="item.id">
                                <span class="name">{{item.name}}</span>
                                <span class="badge badge-primary">{{item.date.toLocaleDateString()}}</span>
                                <div class="btn-group float-right">
                                    <button class="btn btn-sm btn-outline-primary" @click="complete(item.id)">완료</button>
                                    <button class="btn btn-sm btn-outline-danger" @click="del(item.id)">삭제</button>
                                </div>
                            </li>
                        </transition-group>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col">
                        <h2>Complete List</h2>
                        <ul class="list-group">
                            <li class="list-group-item" v-for="item in cList" :key="item.id">
                                <span class="name">{{item.name}}</span>
                                <span class="badge badge-success">{{item.date.toLocaleDateString()}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'todo-compo',
        mounted(){
            this.$http.get('http://localhost/read.php')
            .then(result => {
                this.list = result.data.map(x => {
                    x.date = new Date(x.date);
                    return x;
                });
            });
        },
        data () {
            return {
                list:[],
                cList:[],
                idx:5,
                todoText:'',
            };
        },
        methods:{
            del(idx){
                let id = this.list.findIndex( x => x.id == idx);
                this.list.splice(id, 1);
            },
            add(){
                if(this.todoText.trim() == ""){
                    alert("공백은 입력할 수 없습니다.");
                    return;
                }
                this.list.push({id: this.idx++, name:this.todoText, date: new Date()});
                
                let form = new FormData();
                form.append("todo", this.todoText);
                this.$http.post('http://localhost/post.php', form)
                .then( res => {
                    console.log(res.data);
                });
            },
            complete(idx){
                let id = this.list.findIndex(x => x.id == idx);
                let item = this.list.splice(id, 1)[0];
                item.date = new Date();
                this.cList.push(item);
            }
        }
    }
</script>

<style scoped>
    .todo-enter, .todo-leave-to {
        opacity: 0;
        transform:translateX(-100px);
    }

    .todo-enter-active {
        transition:all 1s;
    }

    .todo-leave-active {
        transition:all 1s;
        position:absolute;
    }
    .todo-move {
        transition: transform 1s;
    }
</style>