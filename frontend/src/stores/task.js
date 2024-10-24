import { ref, computed } from "vue";
import { defineStore } from "pinia";
import { allTasks, createTask } from "../http/task-api";

export const useTaskStore = defineStore("taskStore", () => {
    const tasks = ref([]);

    const uncompletedTasks = computed(() =>
        tasks.value.filter((task) => !task.is_completed)
    );
    const completedTasks = computed(() =>
        tasks.value.filter((task) => task.is_completed)
    );

    const fetchAllTasks = async () => {
        const { data } = await allTasks();
        tasks.value = data.data;
    };

    const handleAddedTask = async (newTask) => {
        const { data: createdTask } = await createTask(newTask);
        tasks.value.unshift(createdTask.data);
    };

    return {
        tasks,
        completedTasks,
        uncompletedTasks,
        fetchAllTasks,
        handleAddedTask,
    };
});
