<template>
    <li class="list-group-item py-3">
        <div
            class="d-flex justify-content-start align-items-center"
            @dblclick="($event) => (isEdit = true)"
        >
            <input
                class="form-check-input mt-0"
                :class="completedClass"
                type="checkbox"
                :checked="task.is_completed"
            />
            <div
                class="ms-2 flex-grow-1"
                title="Double click the text to edit or remove"
                :class="completedClass"
            >
                <div class="relative" v-if="isEdit">
                    <input
                        class="editable-task"
                        type="text"
                        @keyup.esc="undo"
                        @keyup.enter="updateTask"
                        v-model="editingTask"
                        v-focus
                    />
                </div>
                <span v-else>{{ task.name }}</span>
            </div>
            <div class="task-date">24 Feb 12:00</div>
        </div>
        <TaskActions @edit="($event) => (isEdit = true)" v-show="!isEdit" />
    </li>
</template>

<script setup>
import { computed, ref } from "vue";
import TaskActions from "./TaskActions.vue";

const props = defineProps({
    task: Object,
});

const emit = defineEmits(['updated'])

const isEdit = ref(false);
const editingTask = ref(props.task.name)

const completedClass = computed(() =>
    props.task.is_completed ? "completed" : ""
);

const vFocus = {
    mounted: (el) => el.focus(),
};

const undo = () => {
    isEdit.value = false
    editingTask.value = props.task.name
}


const updateTask = event => {
    const updatedTask = {...props.task, name: event.target.value}
    isEdit.value = false
    emit('updated', updatedTask)
}
</script>
