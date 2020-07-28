<template>
    <div class="pizzas">
        <div class="alert my-3" v-bind:class="{'alert-success': success}" v-if="success" v-text="info"></div>
        <div v-if="error" class="alert alert-danger" role="alert">
            <div v-for="error in errors">
                <span>{{ error }}</span>
            </div>
        </div>
        <div class="btn-group pb-3">
            <a v-bind:href="'/admin/pizzas/create'" class="btn btn-primary">
                Create new Pizza
            </a>
        </div>

        <div class="card mb-4" v-for="(pizza, keyP) in objPizzas">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="mr-auto">{{pizza.name}}</span>
                <span class="badge badge-primary badge-pill">{{pizza.price}} &#8364;</span>
                <span class="button-group ml-4">
                    <a v-bind:href="'/admin/pizzas/' + pizza.id + '/edit'" class="btn btn-outline-secondary btn-sm">Edit</a>
                    <a v-if="pizza.ingredients.length === 0" v-bind:href="'javascript:void(0)'" v-on:click="deletePizza(pizza.id, keyP)" class="btn btn-danger btn-sm">Delete</a>
                </span>
            </div>
            <div class="card-body">
                <ul v-if="pizza.ingredients.length > 0" class="list-group">
                    <li v-for="(ingredient, keyI) in pizza.ingredients" class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="mr-auto">{{ingredient.name}}</span>
                        <span class="badge badge-primary badge-pill">{{ingredient.price}} &#8364;</span>
                        <span class="button-group ml-4">
                            <a v-bind:href="'/admin/ingredients/' + ingredient.id + '/edit?pizza_id=' + pizza.id" class="btn btn-outline-secondary btn-sm">Edit</a>
                            <a v-bind:href="'javascript:void(0)'" v-on:click="deleteIngredient(ingredient.id, keyP, keyI)" class="btn btn-danger btn-sm">Delete</a>
                        </span>
                    </li>
                </ul>
                <div class="form-group pt-3 d-flex justify-content-between align-items-center">
                    <a v-bind:href="'/admin/ingredients/create?pizza_id=' + pizza.id" class="btn btn-success btn-sm">Create new Ingredient</a>
                    <span class="badge badge-primary badge-pill total-price" v-if="pizza.total_price">Total price: {{pizza.total_price}} &#8364;</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data:function () {
            return{
                error: false,
                errors: {},
                success: false,
                info: null,
                objPizzas: this.pizzas
            }
        },
        props: {
            pizzas: Array
        },
        name: "PizzasIndex",
        methods: {
            deleteIngredient(id, keyP, keyI) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/admin/ingredients/' + id)
                        .then(function (resp) {
                            console.log(resp);
                            app.error = false;
                            app.errors = null;
                            app.pizzas[keyP].ingredients.splice(keyI, 1);
                            if (resp.data.result.ingredient.id)  {
                                app.success = true;
                                app.info = 'Ingredient "' + resp.data.result.ingredient.name + '" successfully deleted';
                                app.objPizzas = resp.data.result.pizzas;
                                setTimeout(function(){
                                    app.success = false;
                                    app.info = null;
                                }, 2000);
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                            app.error = true;
                            app.errors = error.response.data.errors || {};
                        });
                }
            },
            deletePizza(id, keyP) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/admin/pizzas/' + id)
                        .then(function (resp) {
                            console.log(resp);
                            app.error = false;
                            app.errors = null;
                            app.pizzas.splice(keyP, 1);
                            if (resp.data.result.id)  {
                                app.success = true;
                                app.info = 'Pizza "' + resp.data.result.name + '" successfully deleted';
                                setTimeout(function(){
                                    app.success = false;
                                    app.info = null;
                                }, 2000);
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                            app.error = true;
                            app.errors = error.response.data.errors || {};
                        });
                }
            }
        }
    }
</script>

<style scoped>
    .badge {
        line-height: normal;
    }
    .total-price {
        font-size:1em;
    }
</style>