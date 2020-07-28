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
                New Pizza
            </div>
            <div class="card-body">
                <form v-on:submit="updatePizza()">
                    <div class="row">
                        <div class="col-12 form-group">
                            <label class="control-label">Pizza name</label>
                            <input type="text" v-model="pizza.name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 form-group">
                            <label class="control-label">Price</label>
                            <input type="text" v-model="pizza.price" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 form-group">
                            <button class="btn btn-success">Create Pizza</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PizzasEdit",
        props: {
            pizza: Object
        },
        data: function () {
            return {
                validate: true,
                info: null,
                error: false,
                errors: {},
                success: false,
            }
        },
        methods: {
            updatePizza() {
                event.preventDefault();
                var app = this;
                axios.put('/admin/pizzas/' + app.pizza.id, app.pizza)
                    .then(function (resp) {
                        app.error = false;
                        app.validate = true;
                        app.info = null;
                        console.log(resp.data);
                        if (!resp.data.result){
                            app.validate = resp.data.validate;
                            app.info = resp.data.info[0];
                        } else {
                            if (resp.data.result.id)  {
                                app.success = true;
                                app.info = 'Pizza "' + resp.data.result.name + '" successfully updated';
                                setTimeout(function(){
                                    window.location.href = '/admin/pizzas'}, 1000);
                            }
                        }
                    })
                    .catch(function (error) {
                        console.log(error.response);
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