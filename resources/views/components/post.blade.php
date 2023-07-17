@props(['post' => $post])

<div class="mb-4">
    <a href="{{ route('users.posts', $post->user) }}" class="font-bold">{{ $post->user->name }}</a> <span
        class="text-gray-600 text-sm">{{ $post->created_at->diffForHumans() }}</span>

    <p class="mb-2">{{ $post->body }}</p>

    <div class="items-center flex">
        @auth
        @if (!$post->likedBy(auth()->user()))
        <form action="{{ route('posts.likes', $post) }}" class="mr-1" method="post">
            @csrf
            <button class="text-blue-500" type="submit">Like</button>
        </form>
        @else
        <form action="{{ route('posts.likes', $post) }}" class="mr-1" method="post">
            @csrf
            @method('DELETE')
            <button class="text-blue-500" type="submit">Unlike</button>
        </form>
        @endif

        @can('delete', $post)
        <div>
            <form action="{{ route('posts.destroy', $post) }}" class="mr-1" method="post">
                @csrf
                @method('DELETE')
                <button class="text-blue-500" type="submit">Delete</button>
            </form>
        </div>
        @endcan
        @endauth

        <span>{{ $post->likes->count() }} {{ Str::plural('like', $post->likes->count()) }}</span>
    </div>
</div>
