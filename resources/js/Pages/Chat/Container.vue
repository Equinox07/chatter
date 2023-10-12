<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import MessageContainer from './MessageContainer.vue';
import InputMessage from './InputMessage.vue';
import axios from 'axios';
import { onMounted, ref, watch, reactive, watchEffect } from 'vue';
import ChatRoomSelection from './ChatRoomSelection.vue';
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
let currentRoom = reactive({});
let someRoom = ref("");
let messages = ref([]);

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
    // console.log("Room change", room);
    // var anotherRoom = ''
    // if (!room.id) {
    //     var anotherRoom = room.value
    // }
    // console.log("Another change", anotherRoom);
    currentRoom = room
    someRoom.value = room
    // console.log("Another room", currentRoom);
    getMessages()
    // console.log(currentRoom);
}

function getMessages(){
    axios.get('/chat/rooms/' + currentRoom.id + '/messages')
    .then(response => {
        messages.value = response.data
    }).catch(err => {
        console.log(err);
    })
}

function connectIO(){
    console.log("Checking current room Id", currentRoom.id);
    if (currentRoom.id) {
        let vm = this
        getMessages()
        window.Echo.private("chat." + currentRoom.slug)
            .listen("NewChatMessage", (e) => {
            console.log("Fetching messages...");
            getMessages();
        })
    }
}

function disconnectIO(room){
    window.Echo.leave("chat." + room.slug);
}

watch(someRoom, (newRoom, oldRoom) =>{
    if (oldRoom.id) {
        console.log("Disconnecting from this tour....", oldRoom.name);
        disconnectIO(oldRoom)
    }
    // console.log("New Room", newRoom);
    // console.log("Old Room", oldRoom);
   connectIO()
});

onMounted(() => {
    getRooms();
});

</script>

<template>
    <AppLayout title="Chat">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <ChatRoomSelection
                v-if="currentRoom.id"
                :rooms="chatRooms"
                :currentRoom="currentRoom"
                @roomChanged="setRoom($event)"
                />
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <!-- <Welcome /> -->
                    <MessageContainer :messages="messages" />
                    <!-- {{ chatRooms }} -->
                    <InputMessage :room="currentRoom" @message-sent="getMessages()" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
