<template>
    <form class="form-horizontal" method="POST" :action="route_build">

        <input type="hidden" name="_token" :value="csrf">
        <input type="hidden" name="language_id" :value="language.id">
        <div class="form-group">
            <label for="number" class="col-md-4 control-label">Number</label>

            <div class="col-md-6">
                <input id="number" type="number" class="form-control" name="number" v-model="number" min="0" required>
            </div>
        </div>

        <div class="form-group">
            <label for="number" class="col-md-4 control-label">Languages</label>

            <div class="col-md-6">
                <select name="language" class="form-control" v-model="language">
                    <option value="">All Languages</option>
                    <option v-for="lang in languages" :value="lang">{{ lang.title }}</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="number" class="col-md-4 control-label">Topics</label>

            <div class="col-md-6">
                <select name="topic_id" class="form-control" v-model="topic" :disabled="!language">
                    <option value="">All Topics</option>
                    <option v-for="topic in language.topics" :value="topic.id">{{ topic.title }}</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Start
                </button>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.');
        },

        props: {
            route_build: {
                required: true,
            },
            languages: {
                required: true,
            },
            csrf: {
                required: true,
            },
        },

        data() {
            return {
                number : "",
                topic : "",
                language : "",
            }
        },

        computed : {
            allLangs: function () {
                var lan = [];
                if (this.language != "") {
                    for (var i=0; i < this.languages.length; i++) {
                        if (this.languages[i].id == this.language) {
                            lan = this.language[i];
                            break;
                        }
                    }
                }

                return lan;
            },
        },
    }
</script>
