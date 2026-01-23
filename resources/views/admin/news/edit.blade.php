<x-app-layout>
    <x-slot name="header">
        <div
            class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl px-4 py-4">
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight mx-auto">
                Edit News Article
            </h2>
        </div>
    </x-slot>

    <div
        class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 transition-colors duration-500">
        <div class="max-w-4xl mx-auto px-6">

            {{-- Notifications --}}
            @if (session('success'))
                <x-notification type="success" :message="session('success')" />
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <x-notification type="error" :message="$error" />
                @endforeach
            @endif

            {{-- Card --}}
            <div
                class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md 
                        rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 
                        p-8 transition-all duration-500 ease-in-out">

                <h3
                    class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6 
                           tracking-tight border-b border-gray-200 dark:border-gray-700 pb-3">
                    Edit News Information
                </h3>

                <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div x-data="slugger({
                        initialTitle: @js(old('title', $news->title)),
                        initialSlug: @js(old('slug', $news->slug)),
                    })" class="space-y-6">
                        {{-- Title --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                            <input type="text" name="title" x-model="title" @input="onTitleInput"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600
                   bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                   focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400
                   focus:outline-none transition-all duration-300"
                                placeholder="Enter article title">
                        </div>

                        {{-- Slug --}}
                        <div>
                            <div class="flex items-center justify-between">
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Slug</label>
                                <button type="button" @click="forceGenerate()"
                                    class="text-xs font-semibold text-gray-600 dark:text-gray-300 hover:underline">
                                    Generate
                                </button>
                            </div>

                            <input type="text" name="slug" x-model="slug" @input="slugTouched=true"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600
                   bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                   focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400
                   focus:outline-none transition-all duration-300"
                                placeholder="unique-news-slug">

                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Auto-generated from title. You can edit it anytime.
                            </p>
                        </div>
                    </div>

                    {{-- Content (Markdown) --}}
                    <div x-data="markdownEditor({
                        initial: @js(old('content', $news->content)),
                    })" class="space-y-3">
                        <div class="flex items-center justify-between gap-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Content (Markdown)
                            </label>

                            <div class="flex items-center gap-2">
                                <button type="button" @click="tab='write'"
                                    :class="tab === 'write' ? 'bg-gray-900 text-white dark:bg-gray-100 dark:text-gray-900' :
                                        'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200'"
                                    class="px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                    Write
                                </button>
                                <button type="button" @click="tab='preview'"
                                    :class="tab === 'preview' ? 'bg-gray-900 text-white dark:bg-gray-100 dark:text-gray-900' :
                                        'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200'"
                                    class="px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                    Preview
                                </button>
                            </div>
                        </div>

                        {{-- Mini toolbar --}}
                        <div class="flex flex-wrap items-center gap-2">
                            <button type="button" @click="insertImageCaptionMarker()"
                                class="px-2 py-1 rounded-lg text-xs bg-gray-100 dark:bg-gray-700">
                                Image & Caption
                            </button>
                            <button type="button" @click="wrap('**','**')"
                                class="px-2 py-1 rounded-lg text-xs bg-gray-100 dark:bg-gray-700">Bold</button>
                            <button type="button" @click="wrap('*','*')"
                                class="px-2 py-1 rounded-lg text-xs bg-gray-100 dark:bg-gray-700">Italic</button>
                            <button type="button" @click="prefix('# ')"
                                class="px-2 py-1 rounded-lg text-xs bg-gray-100 dark:bg-gray-700">H1</button>
                            <button type="button" @click="prefix('## ')"
                                class="px-2 py-1 rounded-lg text-xs bg-gray-100 dark:bg-gray-700">H2</button>
                            <button type="button" @click="prefix('- ')"
                                class="px-2 py-1 rounded-lg text-xs bg-gray-100 dark:bg-gray-700">List</button>
                            <button type="button" @click="prefix('> ')"
                                class="px-2 py-1 rounded-lg text-xs bg-gray-100 dark:bg-gray-700">Quote</button>
                            <button type="button" @click="codeBlock()"
                                class="px-2 py-1 rounded-lg text-xs bg-gray-100 dark:bg-gray-700">Code</button>
                            <button type="button" @click="insertLink()"
                                class="px-2 py-1 rounded-lg text-xs bg-gray-100 dark:bg-gray-700">Link</button>
                        </div>

                        {{-- Write / Preview --}}
                        <div class="grid grid-cols-1 gap-3">
                            <div x-show="tab==='write'" x-cloak>
                                <textarea x-ref="ta" name="content" x-model="value" rows="12"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600
                       bg-gray-800 dark:bg-gray-700 text-gray-100 dark:text-gray-100
                       focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400
                       focus:outline-none transition-all duration-300
                       font-mono text-sm leading-relaxed"
                                    placeholder="# Big title

## Subtitle

Write **bold**, *italic*…
- list
> quote
`inline code`

[link](https://example.com)
"></textarea>

                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    Markdown supported. Final render will be sanitized & parsed on the show page.
                                </p>
                            </div>

                            <div x-show="tab==='preview'" x-cloak
                                class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
                                <div class="prose prose-sm dark:prose-invert max-w-none" x-html="previewHtml"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Image Upload --}}
                    <div x-data="productMainImageUpload({ maxMB: 5, initialUrl: @js($news->image ?? null) })">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            Featured Image
                        </label>

                        {{-- error --}}
                        <template x-if="error">
                            <p class="text-sm text-red-600 mb-3" x-text="error"></p>
                        </template>

                        <div @drop.prevent="onDrop($event)" @dragover.prevent="isDragging = true"
                            @dragleave.prevent="isDragging = false" @click="$refs.mainInput.click()"
                            :class="isDragging ? 'border-blue-400 bg-blue-50' : 'border-gray-300'"
                            class="relative border-2 border-dashed rounded-2xl p-8
               bg-gray-50 dark:bg-gray-700 cursor-pointer
               transition-all duration-200 hover:border-blue-400
               hover:bg-blue-50 dark:hover:bg-gray-600 group">
                            <input type="file" name="image" x-ref="mainInput" accept="image/*" class="hidden"
                                @change="onChange($event)">

                            {{-- Preview --}}
                            <template x-if="preview">
                                <div class="relative">
                                    <img :src="preview" alt="News Image"
                                        class="w-full h-64 object-cover rounded-xl shadow-lg" />
                                    <button type="button" @click.stop="clear()"
                                        class="absolute -top-2 -right-2 w-8 h-8 bg-white/90 backdrop-blur-sm
                           hover:bg-red-500 text-gray-600 hover:text-white
                           rounded-full flex items-center justify-center shadow-lg
                           hover:shadow-xl transition-all duration-300 ease-out
                           hover:scale-110 border border-gray-200/50 hover:border-red-500"
                                        title="Remove Image">
                                        <svg class="w-4 h-4 transition-transform duration-200 hover:rotate-90"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>

                            {{-- Placeholder --}}
                            <template x-if="!preview">
                                <div class="text-center">
                                    <div
                                        class="w-16 h-16 mx-auto mb-4 bg-gray-200 dark:bg-gray-600
                            rounded-full flex items-center justify-center
                            group-hover:bg-blue-100 transition-colors">
                                        <svg class="w-8 h-8 text-gray-400 group-hover:text-blue-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-300 font-medium mb-1">Upload Featured Image
                                    </p>
                                    <p class="text-sm text-gray-500">PNG, JPG up to 5MB</p>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Gallery Images (News) --}}
                    <div x-data="productGalleryUpload({
                        maxMB: 5,
                        maxImages: 4,
                        initial: @js($news->gallery_images ?? []) // <-- m phải chuẩn hoá data ở controller
                    })">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            Gallery Images (Maximum 4 images)
                        </label>

                        <template x-if="error">
                            <p class="text-sm text-red-600 mb-3" x-text="error"></p>
                        </template>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <template x-for="(item, index) in gallery" :key="index">
                                <div class="aspect-square">
                                    <template x-if="item === null">
                                        <div @drop.prevent="onDropToSlot($event, index)"
                                            @dragover.prevent="isDragging = true"
                                            @dragleave.prevent="isDragging = false" @click="openPicker()"
                                            :class="isDragging ? 'border-blue-400 bg-blue-50' : 'border-gray-300'"
                                            class="w-full h-full border-2 border-dashed rounded-xl bg-gray-50 dark:bg-gray-700 cursor-pointer
                                transition-all duration-200 hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-gray-600
                                flex flex-col items-center justify-center group">
                                            <div
                                                class="w-8 h-8 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center mb-2
                                    group-hover:bg-blue-100 transition-colors">
                                                <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                            </div>
                                            <span class="text-xs text-gray-500 text-center px-1"
                                                x-text="`Image ${index + 1}`"></span>
                                        </div>
                                    </template>

                                    <template x-if="item !== null">
                                        <div class="relative w-full h-full group">
                                            <img :src="item.url" :alt="`Gallery Image ${index + 1}`"
                                                class="w-full h-full object-cover rounded-xl shadow-md" />

                                            <button type="button" @click.stop="removeImage(index)"
                                                class="absolute -top-2 -right-2 w-6 h-6 bg-white/95 backdrop-blur-sm
                                   hover:bg-red-500 text-gray-600 hover:text-white rounded-full
                                   flex items-center justify-center shadow-md hover:shadow-lg
                                   opacity-0 group-hover:opacity-100 transition-all duration-300 ease-out
                                   hover:scale-125 border border-gray-200/50 hover:border-red-500"
                                                title="Remove Image">
                                                <svg class="w-3 h-3 transition-all duration-200" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>

                        <input type="file" name="gallery_images[]" multiple x-ref="galleryInput" accept="image/*"
                            class="hidden" @change="onPick($event)">

                        <input type="hidden" name="deleted_image_ids" x-ref="deletedImagesInput">
                    </div>

                    {{-- Actions --}}
                    <div class="flex justify-end space-x-4 pt-6">
                        <a href="{{ route('admin.news.index') }}"
                            class="px-5 py-2 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-300 
                                  hover:text-gray-900 dark:hover:text-white hover:bg-gray-100/50 
                                  dark:hover:bg-gray-700/40 transition-all duration-300">
                            Cancel
                        </a>
                        <button type="submit" x-data="loadingButton" @click="handleClick" data-loading
                            class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-gray-900 to-gray-700 
                                   dark:from-gray-100 dark:to-gray-300 
                                   text-white dark:text-gray-900 font-semibold text-sm 
                                   shadow-lg hover:shadow-xl hover:scale-[1.02]
                                   hover:from-gray-800 hover:to-gray-600
                                   transition-all duration-300 ease-in-out">
                            Update Article
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
