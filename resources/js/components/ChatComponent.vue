<template>
    <div id="screenChat" class="flex h-screen antialiased text-gray-800">
        <div class="flex flex-row h-full w-full overflow-x-hidden">
            <div class="flex flex-col flex-auto h-full p-10 xl:px-32 md:px-20">
                <div class="flex flex-col flex-auto flex-shrink-0 rounded-2xl bg-blue-50 h-full shadow-lg">
                    <div class="flex flex-row items-center h-16 w-auto bg-blue-200 w-full p-8 mb-2 rounded-t-xl border-b-2 border-gray-600">
                        <div class="relative">
                            <div class="flex items-center justify-center h-12 w-12 rounded-full flex-shrink-0 shadow-md bg-green-400 border-2 border-green-800">
                                <img :src="'/assets/img/yoda.png'" class="h-full w-full" alt="" />
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-xl font-semibold text-gray-700">
                                Yoda Bot
                            </p>
                            <p class="text-md font-normal text-gray-800 italic" v-bind:class="
                                    this.isWriting ? 'd-block' : 'd-none'
                                ">
                                writing...
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col h-full overflow-x-auto mb-4">
                        <div class="flex flex-col h-full">
                            <div v-for="message in messages" class="grid grid-cols-12 gap-y-2">
                                <div v-if="message.isBot" class="col-start-1 col-end-8 p-3 rounded-lg">
                                    <div class="flex flex-row items-center">
                                        <div class="flex items-center justify-center h-10 w-10 rounded-full  bg-green-400 border-2 border-green-800 flex-shrink-0">
                                            <img :src="'/assets/img/yoda.png'" class="h-full w-full" alt="" />
                                        </div>
                                        <div class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">
                                            <div>{{ message.msg }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="col-start-6 col-end-13 p-3 rounded-lg">
                                    <div class="flex items-center justify-start flex-row-reverse">
                                        <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0 border-2 border-indigo-800">
                                            <img :src="
                                                    '/assets/img/programmer.png'
                                                " class="w-7 pl-1" alt="" />
                                        </div>

                                        <div class="relative mr-3 text-sm bg-green-100 py-2 px-4 shadow rounded-xl">
                                            <div>
                                                {{ message.msg }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form class="flex flex-row items-center h-16 md:h-20 rounded-b-xl bg-white w-full px-2 md:px-10 shadow">
                        <div class="flex-grow">
                            <div class="relative w-full">
                                <input type="text" id="inputChat" v-model="msg" placeholder="Write a message..." class="flex w-full border rounded-xl focus:outline-none focus:border-indigo-300 pl-4 h-10" />
                            </div>
                        </div>
                        <div class="ml-2 md_ml-4">
                            <button @click.prevent="messageSent" class="flex items-center justify-center bg-indigo-500 hover:bg-indigo-600 rounded-xl text-white px-4 py-2 flex-shrink-0">
                                <span>Send</span>
                                <span class="ml-2">
                                    <svg class="w-4 h-4 transform rotate-45 -mt-px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                messages: [],
                messageObject: {
                    isBot: false,
                    msg: ""
                },
                msg: "",
                isWriting: false,
                isNotFound: false,
                keyWord: "force"
            };
        },

        methods: {
            messageSent() {
                if (this.msg != "") {
                    this.messages.unshift({
                        isBot: false,
                        msg: this.msg
                    });
                    this.isWriting = true;
                    this.sendMessageToBot(this.msg);
                    this.msg = "";
                }
            },
            sendMessageToBot(message) {
                const apiKey = "nyUl7wzXoKtgoHnd2fB0uRrAv0dDyLC+b4Y6xngpJDY=";
                const secret =
                    "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJwcm9qZWN0IjoieW9kYV9jaGF0Ym90X2VuIn0.anf_eerFhoNq6J8b36_qbD4VqngX79-yyBKWih_eA1-HyaMe2skiJXkRNpyWxpjmpySYWzPGncwvlwz5ZRE7eg";

                var accessToken = "";
                var chatbotApiUrl = "";
                var sessionToken = "";

                // Get authorization
                fetch("https://api.inbenta.io/v1/auth", {
                        method: "POST",
                        headers: {
                            "x-inbenta-key": apiKey,
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            secret: secret
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        accessToken = data.accessToken;
                        console.log(data);
                        // Get Chatbot API URL
                        fetch("https://api.inbenta.io/v1/apis", {
                                method: "GET",
                                headers: {
                                    "x-inbenta-key": apiKey,
                                    Authorization: "Bearer " + accessToken
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                chatbotApiUrl = data.apis.chatbot;
                                console.log(data);
                                // Get session token
                                fetch(chatbotApiUrl + "/v1/conversation", {
                                        method: "POST",
                                        headers: {
                                            "x-inbenta-key": apiKey,
                                            Authorization: "Bearer " + accessToken
                                        }
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        sessionToken = data.sessionToken;
                                        console.log(data);
                                        console.log("mensaje: " + message);
                                        // Get answers
                                        fetch(
                                                chatbotApiUrl +
                                                "/v1/conversation/message", {
                                                    method: "POST",
                                                    headers: {
                                                        "x-inbenta-key": apiKey,
                                                        Authorization: "Bearer " + accessToken,
                                                        "x-inbenta-session": "Bearer " + sessionToken,
                                                        "Content-Type": "application/json"
                                                    },
                                                    body: JSON.stringify({
                                                        message: message
                                                    })
                                                }
                                            )
                                            .then(response => response.json())
                                            .then(data => {
                                                console.log(data);
                                                data.answers.forEach(answer => {
                                                    if (message.includes(this.keyWord)) {
                                                        this.isNotFound = false;
                                                        fetch("https://inbenta-graphql-swapi-prod.herokuapp.com/api", {
                                                                method: "POST",
                                                                headers: {
                                                                    "Content-Type": "application/json"
                                                                },
                                                                body: JSON.stringify({
                                                                    query: '{allFilms{films{title}}}'
                                                                })
                                                            }).then(response => response.json())
                                                            .then(data => {
                                                                var json = JSON.parse(JSON.stringify(data.data.allFilms.films));
                                                                var moviesMsg = "To watch these movies in order to improve your force you need: ";
                                                                var firstOne = true;
                                                                json.forEach(movie => {
                                                                    if (firstOne) {
                                                                        firstOne = false;
                                                                        moviesMsg += movie.title;
                                                                    } else {
                                                                        moviesMsg += ", " + movie.title;
                                                                    }
                                                                });
                                                                this.messages.unshift({
                                                                    isBot: true,
                                                                    msg: moviesMsg
                                                                });
                                                            })
                                                    } else {
                                                        if (answer.flags.includes('no-results')) {
                                                            if (!this.isNotFound) {
                                                                this.isNotFound = true;
                                                                this.messages.unshift({
                                                                    isBot: true,
                                                                    msg: answer.message
                                                                });
                                                            } else {
                                                                fetch("https://inbenta-graphql-swapi-prod.herokuapp.com/api", {
                                                                        method: "POST",
                                                                        headers: {
                                                                            "Content-Type": "application/json"
                                                                        },
                                                                        body: JSON.stringify({
                                                                            query: '{allPeople(first: 5){people{name}}}'
                                                                        })
                                                                    })
                                                                    .then(response => response.json())
                                                                    .then(data => {
                                                                        this.isNotFound = false;
                                                                        console.log('Films: ' + JSON.stringify(data.data.allPeople.people));
                                                                        var json = JSON.parse(JSON.stringify(data.data.allPeople.people));
                                                                        var charactersMsg = "Ok, have a look at these mates, let us: ";
                                                                        var firstOne = true;
                                                                        json.forEach(person => {
                                                                            if (firstOne) {
                                                                                firstOne = false;
                                                                                charactersMsg += person.name;
                                                                            } else {
                                                                                charactersMsg += ", " + person.name;
                                                                            }
                                                                        });
                                                                        this.messages.unshift({
                                                                            isBot: true,
                                                                            msg: charactersMsg
                                                                        });
                                                                    })
                                                            }
                                                        } else {
                                                            this.isNotFound = false;
                                                            this.messages.unshift({
                                                                isBot: true,
                                                                msg: answer.message
                                                            });
                                                        }
                                                    }
                                                })
                                                this.isWriting = false;
                                            });
                                    });
                            });
                    });
            }
        }
    };
</script>
