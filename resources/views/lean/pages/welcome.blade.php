<div>
    <div class="text-center">
        <h1 class="mb-2 text-4xl font-medium">Welcome to Lean</h1>
        <p class="text-xl">A <em class="text-purple-600">lean</em> framework for building custom admin panels for your customers.</p>
    </div>


    <div class="flex flex-col w-full mt-8 -mx-2">
        <div class="flex flex-row">
            <div class="bg-white w-1/2 rounded-lg p-4 m-2 shadow-sm border-2 border-transparent text-gray-800">
                <h2 class="mb-2 text-2xl text-black">Resources</h2>
                <p>The bread and butter of an admin panel. Resources give you a set of CRUD actions for your database models.</p>
            </div>

            <div class="bg-white w-1/2 rounded-lg p-4 m-2 shadow-sm border-2 border-transparent text-gray-800">
                <h2 class="mb-2 text-2xl text-black">Pages</h2>
                <p>Want a completely custom page, unrelated to specific database models? No problem, just create a page.</p>
            </div>
        </div>

        <div class="flex flex-row">
            <div class="bg-white w-1/2 rounded-lg p-4 m-2 shadow-sm border-2 border-transparent text-gray-800">
                <h2 class="mb-2 text-2xl text-black">Documentation</h2>
                <p>All you need to get started. You may find the documentation <x-lean::link href="https://www.notion.so/Lean-Documentation-b5cf9f8057534966b5f7f8a4d89fd777">here.</x-lean::link></p>
            </div>

            <div class="bg-white w-1/2 rounded-lg p-4 m-2 shadow-sm border-2 border-transparent text-gray-800">
                <h2 class="mb-2 text-2xl text-black">Demo</h2>
                <p>Want to see a working app before writing one from scratch? We've got you covered, just visit our <x-lean::link href="https://github.com/LeanAdmin/ecom-example">demo.</x-lean::link></p>
            </div>
        </div>
    </div>

    <x-lean::navigation.mobile.menu />
</div>
