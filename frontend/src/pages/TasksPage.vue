<template>
    <main style="min-height: 50vh; margin-top: 2rem">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <!-- Add new Task -->
                     <NewTask @added="handleAddedTask" />
                    <!-- List of uncompleted tasks -->
                    <Tasks :tasks="uncompletedTasks" @updated="handleUpdatedTask" />

                    <!-- Show toggle button -->
                     <div class="text-center my-3" v-show="showToggleCompletedBtn">
                        <button class="btn-sm btn-secondary" @click="showCompletedTasks = !showCompletedTasks">
                            <span v-if="showCompletedTasks">Hide completed</span>
                            <span v-else>Show completed</span>
                        </button>
                     </div>

                    <!-- List of completed tasks -->
                    <Tasks :tasks="completedTasks" :show="showCompletedTasks" />

                </div>
            </div>
        </div>
    </main>
</template>
<script setup>
import { onMounted, ref, computed } from 'vue';
import { allTasks, createTask, updateTask } from '../http/task-api'
import Tasks from '../components/tasks/Tasks.vue';
import NewTask from '@/components/tasks/NewTask.vue';

const tasks = ref([])

onMounted(async () => {
    const { data } = await allTasks()
    tasks.value = data.data
})

const uncompletedTasks = computed(() => tasks.value.filter(task => !task.is_completed))
const completedTasks = computed(() => tasks.value.filter(task => task.is_completed))

const showToggleCompletedBtn = computed(() => uncompletedTasks.value.length>0 && completedTasks.value.length>0)
const showCompletedTasks = ref(true)

const handleAddedTask = async (newTask) => {
    const { data: createdTask } =  await createTask(newTask)
    tasks.value.unshift(createdTask.data)
}

const handleUpdatedTask = async (task) => {
    const { data:updatedTask } = await updateTask(task.id, {
        name: task.name
    })
    const currentTask = tasks.value.find(item => item.id === task.id)
    currentTask.name = updatedTask.data.name
}
</script>
