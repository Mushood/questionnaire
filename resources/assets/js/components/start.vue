<template>
    <div class="start_button">
        <ParticleEffectButton
                :visible.sync="btnOps.visible"
                :animating.sync="btnOps.animating"
                :options="btnOps"
                cls="btn-cls"
        >
            START YOUR JOURNEY
        </ParticleEffectButton>
    </div>
</template>

<script>
    import ParticleEffectButton from "vue-particle-effect-buttons"

    export default {
        mounted() {
            this.btnOps.visible=!this.btnOps.visible
        },

        props: {
            route_start: {
                required: true,
            },
        },

        data() {
            return {
                btnOps: {
                    type: "triangle",
                    easing: "easeOutQuart",
                    size: 20,
                    particlesAmountCoefficient: 4,
                    oscillationCoefficient: 0,
                    color: function () {
                        return Math.random() < 0.5 ? "#000000" : "#ffffff";
                    },
                    onComplete: () => {
                        console.log("complete");
                        if (this.loaded) {
                            window.location = this.route_start;
                        } else {
                            this.loaded = true;
                        }

                    },
                    onBegin: () => {
                        console.log("begin");
                    },
                    visible: false,
                    animating: false
                },
                loaded: false
            }
        },
        components: {
            ParticleEffectButton
        }
    };
</script>