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
                        {{ index + 1 }}. {{ selection.question.title }} - <a target="_blank" :href="'/question/edit/' + selection.question.id">Edit</a>
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
                        <h4>Correct answers</h4>
                        <span v-if="selection.question.link">
                            <a :href="selection.question.link" target="_blank">More Info</a> <br />
                        </span>
                        <span v-for="option in selection.question.options">
                            <span v-if="option.correct">{{ option.title }}  <br /></span>
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

                if (this.test.selections[i].answers && this.test.selections[i].answers.length > 0) {
                    for (var j = 0; j < this.test.selections[i].answers.length; j++) {
                        this.answers[i]['answers'].push({
                            'option_id' : this.test.selections[i].answers[j].option_id,
                            'selection_id' : this.test.selections[i].answers[j].selection_id
                        });
                    }
                }
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
                Vue.swal.showLoading({
                    allowOutsideClick: false,
                    enableLoading: true,
                    showConfirmButton:false,
                });
                axios.post(vm.route_assess, {
                    _token: vm.csrf,
                    answers: vm.answers,
                    identifier: vm.test.identifier,
                })
                .then(function (response_axios) {
                    Vue.swal.hideLoading();
                    Vue.swal({
                        title: 'Success!',
                        text: 'Assessment complete',
                        type: 'success',
                        confirmButtonText: 'See Results'
                    }).then(function (response) {
                        window.location = response_axios.data.url;
                    });
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
            },

            loader: function() {
                this.$swal('Hello Vue world!!!');
            },
        },
    }
</script>
