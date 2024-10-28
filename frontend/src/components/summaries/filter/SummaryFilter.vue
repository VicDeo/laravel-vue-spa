<template>
    <div class="dropdown">
        <button
            class="btn btn-secondary dropdown-toggle"
            :class="toggleClass"
            type="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
            @click.prevent="toggleDrop"
        >
            {{ currentValueStr }}
        </button>
        <ul class="dropdown-menu" :class="toggleClass">
            <li v-for="option in options" :key="option.value">
                <a
                    class="dropdown-item"
                    v-show="option.value != currentValue.value"
                    @click.prevent="apply(option)"
                    href="#"
                    >{{ option.label }}</a
                >
            </li>
        </ul>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useRouter } from "vue-router";

const options = [
    { label: "This week", value: "" },
    { label: "Today", value: "today" },
    { label: "Yesterday", value: "yesterday" },
    { label: "Last Week", value: "lastweek" },
    { label: "This Month", value: "thismonth" },
    { label: "Last Month", value: "lastmonth" },
];

const emit = defineEmits(["update"]);
const router = useRouter();

const currentValue = ref(options[0]);
const isOpen = ref(false);

const toggleDrop = () => (isOpen.value = !isOpen.value);
const toggleClass = computed(() => (isOpen.value === true ? "show" : ""));
const currentValueStr = computed(() => currentValue.value.label);

const apply = (newValue) => {
    currentValue.value = newValue;
    router.push({name: 'summary', query: newValue.value});
    emit("update", {label: currentValue.label, value: currentValue.value});
    isOpen.value = false;
};

onMounted(() => emit("update", {label: currentValue.label, value: currentValue.value}));
</script>
