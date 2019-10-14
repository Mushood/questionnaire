<template>
    <form>
        <h1>{{ test.identifier }}</h1>
        <div class="row" v-for="(selection,index) in test.selections">
            <div class="col-md-8 col-md-offset-2">
                <div :class="{'panel': true, 'panel-default': true, 'panel-success': selection.question.isCorrect === true, 'panel-danger': selection.question.isCorrect === false}">
                    <div class="panel-heading" v-if="selection.question.code">
                        {{ index + 1 }}. {{ selection.question.title }}
                        <hr />
                        <code v-html="selection.question.code"></code>
                    </div>
                    <div class="panel-heading" v-else>
                        {{ index + 1 }}. {{ selection.question.title }}
                    </div>

                    <div class="panel-body" v-if="selection.question.type == types.standard">
                        <span v-for="option in shuffle(selection.question.options)">
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
                        <span v-for="option in shuffle(selection.question.options)">
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
                        <span v-if="selection.question.link">
                            <a :href="selection.question.link" target="_blank">More Info</a> <br />
                        </span>
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
                    identifier: vm.test.identifier,
                })
                .then(function (response_axios) {
                    window.location = response_axios.data.url;
                })
                .catch(function (error) {

                });
            },

            shuffle: function(a) {
                for (let i = a.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [a[i], a[j]] = [a[j], a[i]];
                }
                return a;
            }
        },
    }
</script>
