<x-app-layout>
    <div class="relative z-10 max-w-2xl mx-auto p-4 sm:p-6 lg:p-8 bg-gray-900 text-black">
        <form method="POST" action="{{ route('post.store') }}" enctype="multipart/form-data" name="formName">
            @csrf
            <p>
                <label for="photo" class="text-white">Photo</label><br/>
                <input type="file" name="photo" id="photo" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 mb-2">
    
                <!-- Le message d'erreur pour "picture" -->
                @error("photo")
                <div>{{ $message }}</div>
                @enderror
            </p>
            <textarea
                name="msg_content"
                placeholder="{{ __('What\'s on your mind?') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('msg_content') }}</textarea>
            <x-input-error :messages="$errors->get('msg_content')" class="mt-2" />
            <x-primary-button class="mt-4">{{ __('Post') }}</x-primary-button>
        </form>


        <div class="grid grid-cols-2 gap-4 mt-4">
            @foreach ($posts as $post)
            @if ($post->user->is(auth()->user()))
            <div class="bg-white shadow-sm rounded-lg">
                <img src="{{asset('storage/posts/' . $post->photo)}}" alt="image du post" class="w-full h-auto rounded-t-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <span class="text-gray-800">{{ $post->user->name }}</span>
                            <small class="ml-2 text-sm text-gray-600">{{ $post->created_at->format('j M Y, g:i a') }}</small>
                            @unless ($post->created_at->eq($post->updated_at))
                                <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                            @endunless
                        </div>
                        <div class="flex items-center">
                               
                                    <button onclick="window.location='{{route('post.edit', $post)}}'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                                    </svg>   
                                    </button>
                                    <form method="POST" action="{{ route('post.destroy', $post) }}" class="">
                                            @csrf
                                            @method('delete')
                                            <button class="ml-2" :href="route('post.destroy', $post)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                                  </svg>
                                            </button> 
                                        </form>    
                                
                            </div>
                        </div>
                        <p class="mt-4 text-lg text-gray-900">{{ $post->msg_content }}</p>
                    </div>
                </div>
                @endif
            @endforeach
        </div>

    </div>
    <div id="torch" class="fixed inset-0 z-20 pointer-events-none"></div>
</x-app-layout>