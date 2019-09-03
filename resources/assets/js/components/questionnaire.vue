<template>
    <form method="POST" :action="route_assess">
        <h1>{{ test.identifier }}</h1>
        <div class="row" v-for="(selection,index) in test.selections">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ selection.question.title }}</div>

                    <div class="panel-body" v-if="selection.question.type == types.standard">
                        <span v-for="option in selection.question.options">
                            <input
                                type="radio"
                                v-model="answers[index]"
                                :id="option.id"
                                :name="'question_' + selection.id"
                                :value="{selection_id: selection.id, option_id: option.id}"
                            > {{ option.title }}<br>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

    </form>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.');
            this.test = this.test_original;
            this.types = JSON.parse(this.types_original);

            for (var i = 0; i < this.test.selections.length; i++) {
                this.answers[i] = {
                    'selection_id' : this.test.selections[i].id,
                    'option_id' : '',
                } ;
            }
        },

        props: {
            route_assess: {
                required: true,
            },
            test_original: {
                required: true,
            },
            types_original: {
                required: true,
            },
        },

        data() {
            return {
                test : {},
                types: {},
                answers: [],
            }
        },

        methods : {
            searchSubmit: function () {
                const vm = this;
                var name = vm.search.name;
                vm.previous_search = JSON.stringify(vm.search);
                axios.post(vm.route_search, {
                    search: vm.search,
                    changed: vm.changed,
                })
                .then(function (response_axios) {

                })
                .catch(function (error) {

                });
            },
        },
    }
</script>
