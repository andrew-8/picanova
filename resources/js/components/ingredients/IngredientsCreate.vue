<template>
    <div class="">
        <div class="alert my-3" v-bind:class="{'alert-danger': !validate, 'alert-success': success}" v-if="!validate || success" v-text="info"></div>
        <div v-if="error" class="alert alert-danger" role="alert">
            <div v-for="error in errors">
                <span>{{ error }}</span>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                New Ingredient for pizza "{{pizza.name}}"
            </div>
            <div class="card-body">
                <form v-on:submit="saveIngredient()">
                    <div class="row">
                        <div class="col-12 form-group">
                            <label class="control-label">Ingredient name</label>
                            <input type="text" v-model="ingredient.name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 form-group">
                            <label class="control-label">Price</label>
                            <input type="text" v-model="ingredient.price" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 form-group">
                            <label class="control-label">For Pizza</label>
                            <input type="text" v-model="pizza.name" disabled class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 form-group">
                            <button class="btn btn-success">Create Ingredient</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "IngredientsCreate",
        props: {
            pizza: Object
        },
        data: function () {
            return {
                ingredient: {
                    name: '',
                    price: 0,
                    pizza_id: 0
                },
                validate: true,
                info: null,
                error: false,
                errors: {},
                success: false,
            }
        },
        methods: {
            saveIngredient() {
                event.preventDefault();
                var app = this;
                app.ingredient.pizza_id = app.pizza.id;
                var newIngredient = app.ingredient;
                axios.post('/admin/ingredients', newIngredient)
                    .then(function (resp) {
                        app.error = false;
                        app.validate = true;
                        app.info = null;
                        if (!resp.data.result){
                            app.validate = resp.data.validate;
                            app.info = resp.data.info[0];
                        } else {
                            if (resp.data.result.id)  {
                                app.success = true;
                                app.info = 'Ingredient "' + resp.data.result.name + '" successfully created';
                                setTimeout(function(){
                                    window.location.href = '/admin/pizzas'}, 1000);
                            }
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                        app.validate = true;
                        app.error = true;
                        app.errors = error.response.data.errors || {};
                    });
            }
        }
    }


</script>

<style scoped>

</style>