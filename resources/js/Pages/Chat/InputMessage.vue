<script setup>
import axios from 'axios';
import { defineProps, defineComponent } from 'vue';
  const props = defineProps({
    room : Object
  })
  const emits = defineEmits(['messageSent'])

  var message = ""

//   const { room } = toRefs(props)

  function sendMessage() {
    if (message == '') {
        return;
    }
    axios.post('/chat/rooms/' + props.room.id + '/messages', {
        message: message
    })
    .then(response => {
        if (response.status == 201) {
            message = ''
            emits('messageSent')
        }
        console.log(response.data);
        messages = response.data
    }).catch(err => {
        console.log(err);
    })
  }
</script>
<template>
    <div class="relative h-10 m-1">
        <div style="border-top: 1px solid #e6e6e6;" class="grid grid-cols-6" >

            <input type="text" v-model="message" @keyup.enter="sendMessage()"
            placeholder="Say something..."
            class="col-span-5 outline-none p-1" />

            <button
                @click="sendMessage()" class="place-self-end bg-gray-500 hover:bg-blue-700 p-1 mt-1 rounded text-white "
            >Send</button>
        </div>
    </div>
</template>
