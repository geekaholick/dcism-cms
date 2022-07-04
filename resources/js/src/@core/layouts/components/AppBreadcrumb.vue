<template>
    <b-row
        v-if="$route.meta.breadcrumb || $route.meta.pageTitle"
        class="content-header"
    >
        <!-- Content Left -->
        <b-col class="content-header-left mb-2" cols="12" md="9">
            <b-row class="breadcrumbs-top">
                <b-col cols="12">
                    <h2 class="content-header-title float-left pr-1 mb-0">
                        {{ $route.meta.pageTitle }}
                    </h2>
                </b-col>
            </b-row>
        </b-col>
    </b-row>
</template>

<script>
import {
    BBreadcrumb,
    BBreadcrumbItem,
    BRow,
    BCol,
    BDropdown,
    BDropdownItem,
    BButton,
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";

export default {
    directives: {
        Ripple,
    },
    components: {
        BBreadcrumb,
        BBreadcrumbItem,
        BRow,
        BCol,
        BDropdown,
        BDropdownItem,
        BButton,
    },
};
</script>
