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
                // The list of messages
                messages: [],
                // The input value
                msg: "",
                // A flag to hide or show the wirting text
                isWriting: false,
                // A flag to know if the last answer was a no-results answer
                isNotFound: false,
                // The key word to show the star wars films
                keyWord: "force"
            };
        },
        created() {
            // Store in session cache the API Key
            sessionStorage.setItem('yodabot-apiKey', "nyUl7wzXoKtgoHnd2fB0uRrAv0dDyLC+b4Y6xngpJDY=");

            // Check if the token is expired
            if (sessionStorage.getItem('yodabot-chatbotapiurl')) {
                fetch(sessionStorage.getItem('yodabot-chatbotapiurl') + "/v1/conversation/history", {
                        method: "GET",
                        headers: {
                            "x-inbenta-key": sessionStorage.getItem('yodabot-apiKey'),
                            "Authorization": "Bearer " + sessionStorage.getItem('yodabot-accesstoken'),
                            "x-inbenta-session": "Bearer " + sessionStorage.getItem('yodabot-sessionToken')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // If it is expired, then generate new tokens
                        if(data.message == "User is not authorized to access this resource with an explicit deny"){
                            this.saveTokens(true);
                        }
                    });
            }
        },
        mounted() {
            // Get the conversation history
            if (sessionStorage.getItem('yodabot-chatbotapiurl')) {
                fetch(sessionStorage.getItem('yodabot-chatbotapiurl') + "/v1/conversation/history", {
                        method: "GET",
                        headers: {
                            "x-inbenta-key": sessionStorage.getItem('yodabot-apiKey'),
                            "Authorization": "Bearer " + sessionStorage.getItem('yodabot-accesstoken'),
                            "x-inbenta-session": "Bearer " + sessionStorage.getItem('yodabot-sessionToken')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(msg => {
                            this.messages.unshift({
                                isBot: msg.user == "bot" ? true : false,
                                msg: msg.message
                            })
                        });
                    });
            }
        },
        methods: {
            // When the button is clicked, the message is sent to the bot
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
            // Get the API access token
            async getAccesToken(apiKey, secret, refresh = false) {
                var accessToken = "";
                if (!sessionStorage.getItem('yodabot-accesstoken') || refresh) {
                    await fetch("https://api.inbenta.io/v1/auth", {
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
                            accessToken = JSON.parse(JSON.stringify(data.accessToken));
                            sessionStorage.setItem('yodabot-accesstoken', accessToken);
                        });
                }
            },
            // Get the API Chatbot URL
            async getChatBotApiUrl(apiKey, accessToken, refresh = false) {
                var chatbotApiUrl = "";
                if (!sessionStorage.getItem('yodabot-chatbotapiurl') || refresh) {
                    // Get Chatbot API URL
                    await fetch("https://api.inbenta.io/v1/apis", {
                            method: "GET",
                            headers: {
                                "x-inbenta-key": apiKey,
                                "Authorization": "Bearer " + accessToken
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            chatbotApiUrl = data.apis.chatbot;
                            sessionStorage.setItem('yodabot-chatbotapiurl', chatbotApiUrl);
                        });
                }
            },
            // Get the session token
            async getSessionToken(apiKey, accessToken, chatbotApiUrl, refresh = false) {
                var sessionToken = "";
                if (!sessionStorage.getItem('yodabot-sessionToken') || refresh) {
                    // Get session token
                    await fetch(chatbotApiUrl + "/v1/conversation", {
                            method: "POST",
                            headers: {
                                "x-inbenta-key": apiKey,
                                "Authorization": "Bearer " + accessToken
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            sessionToken = data.sessionToken;
                            sessionStorage.setItem('yodabot-sessionToken', sessionToken);
                        });
                }
            },
            // Get tokens
            async saveTokens(refresh = false) {
                const apiKey = sessionStorage.getItem('yodabot-apiKey');
                const secret =
                    "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJwcm9qZWN0IjoieW9kYV9jaGF0Ym90X2VuIn0.anf_eerFhoNq6J8b36_qbD4VqngX79-yyBKWih_eA1-HyaMe2skiJXkRNpyWxpjmpySYWzPGncwvlwz5ZRE7eg";

                await this.getAccesToken(apiKey, secret, refresh);
                var accessToken = sessionStorage.getItem('yodabot-accesstoken');
                await this.getChatBotApiUrl(apiKey, accessToken, refresh);
                var chatbotApiUrl = sessionStorage.getItem('yodabot-chatbotapiurl');
                await this.getSessionToken(apiKey, accessToken, chatbotApiUrl, refresh);
                var sessionToken = sessionStorage.getItem('yodabot-sessionToken');
            },
            // Sending the message to the bot and attach the response at the conversation
            async sendMessageToBot(message) {
                const apiKey = sessionStorage.getItem('yodabot-apiKey');

                await this.saveTokens();

                // Loading tokens
                var accessToken = sessionStorage.getItem('yodabot-accesstoken');
                var chatbotApiUrl = sessionStorage.getItem('yodabot-chatbotapiurl');
                var sessionToken = sessionStorage.getItem('yodabot-sessionToken');

                // Sending the message to the bot
                fetch(chatbotApiUrl + "/v1/conversation/message", {
                        method: "POST",
                        headers: {
                            "x-inbenta-key": apiKey,
                            "Authorization": "Bearer " + accessToken,
                            "x-inbenta-session": "Bearer " + sessionToken,
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            message: message
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        data.answers.forEach(answer => {
                            // If the message contains the key word, get the films and display it at the conversation
                            if (message.includes(this.keyWord)) {
                                this.isNotFound = false;
                                // Getting the films
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
                                        // Attach the message at the conversation
                                        this.messages.unshift({
                                            isBot: true,
                                            msg: moviesMsg
                                        });
                                    })
                            } else {
                                // If there is no answer to the query
                                if (answer.flags.includes('no-results')) {
                                    // If it is the first no-result response, attach the answer
                                    if (!this.isNotFound) {
                                        this.isNotFound = true;
                                        this.messages.unshift({
                                            isBot: true,
                                            msg: answer.message
                                        });
                                    } else {
                                        // If it is the second consecutive no-results answer, get the characters and attach them as a new answer
                                        // Getting the characters
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
                                                // Attach the message
                                                this.messages.unshift({
                                                    isBot: true,
                                                    msg: charactersMsg
                                                });
                                            })
                                    }
                                } else {
                                    // If the bot is able to find out an answer to the query
                                    this.isNotFound = false;
                                    this.messages.unshift({
                                        isBot: true,
                                        msg: answer.message
                                    });
                                }
                            }
                        });
                        // Hide the writing text
                        this.isWriting = false;
                    });
            }
        }
    };
</script>
