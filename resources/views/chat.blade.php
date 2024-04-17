@extends('layouts.app')
@section('content')
    <div class=" ml-64 bg-chatgpt-light-gray h-screen flex flex-col text-white">
        <div class="flex items-center justify-between px-4 py-4 border-chatgpt-border-gray">
            <div class="flex items
        -center">
                <button class="text-white">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M4 6C4 5.44772 4.44772 5 5 5H19C19.5523 5 20 5.44772 20 6C20 6.55228 19.5523 7 19 7H5C4.44772 7 4 6.55228 4 6ZM4 12C4 11.4477 4.44772 11 5 11H15C15.5523 11 16 11.4477 16 12C16 12.5523 15.5523 13 15 13H5C4.44772 13 4 12.5523 4 12ZM4 18C4 17.4477 4.44772 17 5 17H12C12.5523 17 13 17.4477 13 18C13 18.5523 12.5523 19 12 19H5C4.44772 19 4 18.5523 4 18Z"
                            fill="currentColor"></path>
                    </svg>
                </button>
                <h2 class="text-white text-lg font-semibold ml-2">ChatGPT</h2>
            </div>
        </div>


        <div class="flex flex-col items-center  overflow-y-scroll no-scrollbar px-4 py-4  bg-transparent flex-1">
            <div class="w-full xl:w-1/2  h-full  px-20">


                @include('components.splashChat')

                <div id="messagecontainer">

                </div>
                @include('components.chatMessage')
            </div>
        </div>

        <div class="flex items-center flex-col justify-between px-4 py-4   w-full ">
            <div class="w-full xl:w-1/2 px-20">

                <div class=" px-4 rounded-xl flex items-center border border-chatgpt-border-gray  mx-auto py-1">
                    <textarea id="question" tabindex="0" dir="auto" rows="1" placeholder="Message ChatGPT…"
                        class="m-0 w-full text-base  border-0 rounded-2xl resize-none bg-transparent focus:ring-0 focus-visible:ring-0 outline-0 dark:bg-transparent py-[10px] pr-10 md:py-3 md:pr-12 max-h-[25dvh] max-h-52 placeholder-black/50 dark:placeholder-white/50 pl-3 md:pl-4"
                        style=" overflow-y: hidden;"></textarea>
                    <button id="sendButton" onclick="generateQuestion()" class="w-max  p-1.5 text-white rounded-xl"><svg
                            width="24" height="24" viewBox="0 0 24 24" fill="none" class="text-white ">
                            <path d="M7 11L12 6L17 11M12 18V7" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </svg>
                    </button>
                </div>

            </div>
            <p class="text-center w-full text-xs text-gray-400 mt-4">ChatGPT can make mistakes. Consider checking important
                information.</p>
        </div>
    </div>


    <script>
        var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
        var splashContainer = document.getElementById('splashContainer');

        activateSendButton()

        function generateQuestion() {
            splashContainer.style.display = 'none';
            const aiQuestion = document.getElementById('question')

            // Get the base URL of the current page
            var baseUrl = window.location.origin;
            var question = aiQuestion.value; // Replace with your desired question
            // addPulseLoader(questionAiImg)
            chatMessage(question)
            axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
            axios.post(baseUrl + '/ai-generator/question', {
                    question: question
                })
                .then(response => {
                    const responseStatus = response.data.status;
                    // console.log(typeof(response.data.status))

                    // console.log(response.data.message)
                    if (response.data.status == 'error') {
                        showAlert(response.data.message, 'danger')
                        return;

                    }

                    // console.log(response.data)
                    let responseData = response.data.data.outputs[0].text;
                    responseData = responseData.replace(/"/g, '');
                    chatMessage(responseData)
                    let i = 0;

                    // typeWriter();
                    // Process the response data here
                    console.log(responseData);
                })
                .catch(error => {

                    // console.log(error)
                    showAlert(error.response.data.message, 'danger')

                })
                .finally(function() {
                    // addPulseLoader(document.getElementById('questionAiImg'))

                })
        }


        function chatMessage(message, type = 'user') {
            const messagecontainer = document.getElementById('messagecontainer')
            row = `<div class="text-left  w-full mt-3">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <img class="h-8 w-8 rounded-full" src="user-avatar.jpg" alt="User Avatar">
        </div>
        <div class="ml-3">
            <div class="text-base font-medium text-white">John Doe</div>
            <div class="mt- text-base text-gray-100">
                ${message}
            </div>
        </div>
    </div>
</div>
`
            messagecontainer.innerHTML += row


        }
        
        // function typeWriter(message) {
        //     if (i < responseData.length) {
        //         aiQuestion.value += responseData.charAt(i);
        //         i++;
        //         setTimeout(typeWriter, 10); // Adjust speed by changing the delay time (in ms)
        //     }
        // }



        function activateSendButton() {
            const question = document.getElementById('question')

            question.addEventListener('input', function() {
                const sendButton = document.getElementById('sendButton')
                if (question.value.length > 0) {

                    sendButton.classList.remove('text-gray-400')
                    sendButton.classList.add('bg-chatgpt-border-gray')
                } else {
                    sendButton.classList.add('text-gray-400')
                    sendButton.classList.remove('bg-chatgpt-border-gray')
                }
            })
        }
    </script>
@endsection
