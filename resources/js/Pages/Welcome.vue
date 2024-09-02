<template>
    <div class="flex justify-center items-center  h-screen">
        <div class="space-x-4" v-if="$page.props.auth.user">
            <Link
                href="/dashboard"
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 mx-4"
            >
                الرئيسية
            </Link>
        </div>
        <div v-else class="space-x-4">
            <Link
                href="/register"
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 mx-4"
            >
                تسجيل
            </Link>
            <Link
                href="/login"
                class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-700"
            >
                تسجيل الدخول
            </Link>
        </div>
    </div>
</template>

