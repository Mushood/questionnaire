<template>
    <form>
        <h1>{{ test.identifier }}</h1>
        <div class="row" v-for="(selection,index) in test.selections">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ selection.question.title }}</div>

                    <div class="panel-body" v-if="selection.question.type == types.standard">
                        <span v-for="option in selection.question.options">
                            <input
                                type="radio"
                                v-model="answers[index]['answers'][0]"
                                :id="option.id"
                                :name="'question_' + selection.id"
                                :value="{selection_id: selection.id, option_id: option.id}"
                            > {{ option.title }}<br>
                        </span>
                    </div>

                    <div class="panel-body" v-if="selection.question.type == types.multiple">
                        <span v-for="option in selection.question.options">
                            <input
                                    type="checkbox"
                                    v-model="answers[index]['answers']"
                                    :id="option.id"
                                    :name="'question_' + selection.id"
                                    :value="{selection_id: selection.id, option_id: option.id}"
                            > {{ option.title }}<br>
                        </span>
                    </div>

                    <div class="panel-footer" v-if="selection.answers.length > 0">
                        <span v-for="answer in selection.answers">
                            {{ answer.option.title }}
                            <span v-if="answer.option.correct"> - Correct</span>
                            <span v-else> - Wrong</span>
                            <br />
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <button type="button" class="btn btn-primary" @click.prevent="submitAnswers">Submit</button>
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
                    'type' : this.test.selections[i].question.type,
                    'answers' : []
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
            csrf: {
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
            submitAnswers: function () {
                const vm = this;
                axios.post(vm.route_assess, {
                    _token: vm.csrf,
                    answers: vm.answers,
                })
                .then(function (response_axios) {
                    window.location = response_axios.data.url;
                })
                .catch(function (error) {

                });
            },
        },
    }
</script>
