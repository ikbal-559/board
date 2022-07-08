<template>
    <div class="container">
        <div class="nav">
            <button class="btn" @click="showAddColumnForm()">Add Column</button>

        </div>
        <div class="columns ">
            <div class="column shadow" v-for="column in columns" v-bind:key="column.id">
                <div class="columnHeader">
                    <h3>{{ column.title }}</h3>
                    <div>
                        <button class="btn addColumn" @click="showAddCardForm(column.id)">Add Card</button>
                        <button class="deleteColumn" @click="deleteColumn(column.id)">X</button>

                    </div>
                </div>


                <draggable class="list-group kanban-column" :move="updateCardOrder"  :list="column.cards" :animation="200" ghost-class="ghost-card" group="cards">
                    <task-component
                            v-for="(card) in column.cards"
                            :key="card.id"
                            :card="card"
                            v-on:show-card-details="showCardDetails(card)"
                    ></task-component>
                </draggable>

            </div>
        </div>
        <modal name="columnForm">
            <form @submit.prevent="addColumn" class="columnForm">
                <h3>Add New Column</h3>
                <div class="form-group">
                    <input type="text" class="form-control" required placeholder="Title" v-model="column.title">
                </div>
                <button type="submit" class="btn btn-success">Save</button>
            </form>
        </modal>
        <modal name="cardForm">
            <form @submit.prevent="addCard" class="cardForm">
                <h3>Card</h3>
                <input type="hidden" v-model="column_id">
                <div class="form-group">
                    <input type="text" class="form-control" required placeholder="Title" v-model="card.title">
                </div>
                <div class="form-group">
                    <textarea rows="5" class="form-control" placeholder="Description"
                              v-model="card.description"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Save</button>
            </form>
        </modal>

    </div>
</template>
<script>
    import draggable from 'vuedraggable'
    export default {
        components: {
            draggable,
        },
        data() {
            return {
                columns: [],
                column: {
                    title: ''
                },
                card: {
                    id: false,
                    title: '',
                    description: ''
                },
                column_id: false
            };
        },


        mounted() {
            axios
                .get('status')
                .then(response => (this.columns = response.data.data))
                .catch(function (error) {
                    console.log(error);
                })
        },
        methods: {
            showAddColumnForm() {
                this.$modal.show('columnForm');
            },
            addColumn() {
                axios.post('status', {
                    title: this.column.title
                }).then(response => {
                    this.$modal.hide('columnForm');
                    this.columns.push(response.data.data)
                    this.column.title='';
                }).catch(error => console.log(error))
            },
            deleteColumn(id) {
                if (confirm('Are You Sure?')) {
                    axios.post('status/delete', {
                        id: id
                    }).then(() => {
                        this.columns = this.columns.filter(function (column) {
                            return column.id != id;
                        });
                    }).catch(error => console.log(error))

                }
            },
            addCardToColumn(data, card){
                this.columns = this.columns.filter(function (column) {
                    if(column.id == data.column_id){
                        if(card.id){
                            column.cards = column.cards.filter(function (cardItem) {
                               if(cardItem.id == card.id){
                                   cardItem.title = data.title;
                                   cardItem.description = data.description;
                               }
                               return cardItem;
                            });
                        }else {
                            column.cards.push(data);
                        }
                    }
                    return column;
                });
            },

            showCardDetails(card) {
                this.card.id=card.id;
                this.card.title=card.title;
                this.card.description=card.description;
                this.showAddCardForm(card.column_id)
            },
            showAddCardForm(id) {
                this.column_id = id;
                this.$modal.show('cardForm');
            },
            addCard() {
                axios.post('cards', {
                    column_id: this.column_id,
                    id: this.card.id,
                    title: this.card.title,
                    description: this.card.description,
                }).then(response => {
                    this.$modal.hide('cardForm');
                    this.addCardToColumn(response.data.data, this.card)
                    this.card.id=false;
                    this.card.title='';
                    this.card.description='';
                    this.column_id=false;
                }).catch(error => console.log(error))
            },
            updateCardOrder({ relatedContext, draggedContext }) {
                setTimeout(function () {
                    axios.post('cards-orders', {
                        card: draggedContext.element,
                        cardTo: relatedContext.element,
                        list: relatedContext.list,
                    }).then(response => {
                    }).catch(error => console.log(error))
                }, 5000);


            }

        }
    };
</script>
