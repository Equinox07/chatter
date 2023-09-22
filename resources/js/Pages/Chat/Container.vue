<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import MessageContainer from './MessageContainer.vue';
import InputMessage from './InputMessage.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';
// export default {
//     data() {
//         return {
//             chatRooms: null
//         }
//     },
//     methods: {
//         getRooms() {
//             axios.get('/chat/rooms')
//                 .then(response => {
//                     console.log(response.data);
//                     this.chatRooms = response.data
//                 });
//         }
//     },

//     mounted() {
//         this.getRooms()
//     },
// }


let chatRooms = ref([]);
let currentRoom = ref({});
let messages = ref({});

async function getRooms() {
   await axios.get('/chat/rooms')
    .then(response => {
        chatRooms.value = response.data
        setRoom(response.data[0])
    }).catch(err => {
        console.log(err);
    })
}

function setRoom(room){
    currentRoom = room
    console.log(currentRoom);
    // getMessages()
}

function getMessages(){
    axios.get('/chat/rooms/' + currentRoom.id + '/messages')
    .then(response => {
        messages = response.data
    }).catch(err => {
        console.log(err);
    })
}

onMounted(() => {
    getRooms();
});

</script>

<template>
    <AppLayout title="Chat">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Chat
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <!-- <Welcome /> -->
                    <MessageContainer />
                    <!-- {{ chatRooms }} -->
                    <InputMessage :room="currentRoom" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
