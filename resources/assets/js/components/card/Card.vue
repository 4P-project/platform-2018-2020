<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title" v-html="title"></h3>
            <span v-if="!disableToggling" class="float-right">
                <i class="fa fa-fw ti-angle-up" :class={rotate:show} @click="show = !show"></i>
            </span>
        </div>
        <div class="card-body" v-show="show">
            <slot></slot>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                show: true
            }
        },
        props: {
            title: {
                required: false
            },
            disableToggling: {
                required: false
            }
        }
    }
</script>
<style>
    .rotate {
        transform: rotate(180deg);
    }
</style>
