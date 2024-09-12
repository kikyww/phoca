<x-app-layout>
	<x-container>
		<div class="flex flex-col gap-8">
			<h2 class="text-lg font-semibold">Timeline</h2>
			<div class="rounded-lg w-fit">
				<a href="{{ route("status.index") }}" class=" rounded-lg px-2 py-4 bg-indigo-700 active:ring-indigo-900 active:bg-indigo-500 hover:bg-indigo-500 font-semibold text-white">Make a Status</a>
			</div>
		</div>

		<div class="grid grid-cols-12 gap-4 mt-4">
			<div class="lg:col-span-8 md:col-span-9 sm:col-span-7 col-span-7">
				@foreach($posts as $post)
					<x-status-card>
						<div class="flex">
							<div class="flex-shrink-0 w-11 h-11 border-2 border-slate-400 rounded-full mr-4">
								{{-- <img class="w-10 h-10 rounded-full" src="https://i.pravatar.cc/150" alt="{{ $status->user->name }}" /> --}}
							</div>
							<div>
								<div class="font-semibold mb-1">
									{{ $post->user->name }}
								</div>
								{{-- <img src="" alt=""> --}}
								<div class="leading-relax">
									{{ $post->content }}
								</div>
								<div class="text-slate-400 mt-2">
									{{ $post->created_at->diffForHumans() }}
								</div>
							</div>
						</div>
					</x-status-card>
				@endforeach
			</div>
			<div class="lg:col-span-4 md:col-span-3 sm:col-span-5 col-span-5 ml-6 ">
				<div>					
					<x-status-card>					
            <h1 class="font-semibold text-lg">Recently Follows</h1>
            <div class="space-y-5">
              {{-- @foreach(Auth::user()->follows()->limit(5)->get() as $user) --}}
                <div class="flex items-center mt-3">
                  <div class="flex-shrink-0 w-11 h-11 border-2 border-slate-400 rounded-full mr-4">
                    {{-- <img class="w-10 h-10 rounded-full flex-shrink-0" src="https://i.pravatar.cc/150" alt="{{ $status->user->name }}" />	 --}}
                  </div>
                  <div class="ml-3">
                    <p class="font-semibold">name</p>
                    {{-- <p class="text-slate-400 text-sm">{{ $user->pivot->created_at->diffForHumans() }}</p> --}}
                  </div>
                </div>
              {{-- @endforeach --}}
            </div>
          </x-status-card>
				</div>
			</div>
		</div>
	</x-container>
</x-app-layout>