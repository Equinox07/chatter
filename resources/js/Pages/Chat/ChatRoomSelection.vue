<template>
    <div class="grid grid-cols-12">
        <div class="font-bold text-xl">
            {{ selected.name }} Chat
        </div>
        <div>
            <select v-model="selected"
            @change="roomHasChanged($event)"
            class="float-right"
            >
                <option
                    v-for="(room, index) in rooms" :key="index" :value="room"
                >
                    {{ room.name }}
                </option>
            </select>
        </div>
    </div>
</template>
<script setup>
    import { defineProps, ref, onMounted, defineEmits } from 'vue';
   const props = defineProps({
        rooms: Array,
        currentRoom: Object
    })

    const emits = defineEmits(['roomChanged'])


    var selected = ref({})

    function roomHasChanged(event){
        // console.log("Selected....", selected);
        emits("roomChanged", selected)
    }

    onMounted(() => {
        selected = props.currentRoom
    });
</script>
