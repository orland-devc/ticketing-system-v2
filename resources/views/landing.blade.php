<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head')
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .float-animation { animation: float 3s ease-in-out infinite; }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .fade-in-up { animation: fadeInUp 0.8s ease-out; }
        
        .gradient-text {
            background: linear-gradient(135deg, #003087 0%, #0055d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .dark .gradient-text {
            background: linear-gradient(135deg, #4a90e2 0%, #67b5ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body>
    <div class="fixed inset-0 z-0">
        <img src="{{ asset('images/assets/psu-bg.jpg') }}" alt="" class="h-full w-full object-cover">
        <div class="absolute inset-0 bg-blue-100/90 dark:bg-gray-950/90"></div>
    </div>
    <!-- Navigation -->
    <nav class="fixed w-full bg-white/50 dark:bg-gray-900/50 backdrop-blur-md z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center">
                        <img src="{{asset('images/assets/PSU logo.png')}}" alt="">
                    </div>
                    <span class="font-bold text-blue-800 dark:text-white text-lg">{{ config('app.name') }}</span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#home" class="text-gray-700 dark:text-gray-300 hover:text-blue-800 dark:hover:text-yellow-400 transition">Home</a>
                    <a href="#features" class="text-gray-700 dark:text-gray-300 hover:text-blue-800 dark:hover:text-yellow-400 transition">Features</a>
                    <a href="#demo" class="text-gray-700 dark:text-gray-300 hover:text-blue-800 dark:hover:text-yellow-400 transition">Demo</a>
                    <a href="#team" class="text-gray-700 dark:text-gray-300 hover:text-blue-800 dark:hover:text-yellow-400 transition">Team</a>
                    <a href="#contact" class="text-gray-700 dark:text-gray-300 hover:text-blue-800 dark:hover:text-yellow-400 transition">Contact</a>
                </div>
                @auth
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 bg-blue-800 dark:bg-yellow-400 text-white dark:text-blue-800 px-4 py-2 rounded-xl hover:bg-opacity-90 transition" wire:navigate>
                        Dashboard
                        <img src="{{ asset(Auth::user()->profile_photo_path) }}" alt="" class="rounded-full h-6 w-6 object-cover border border-white">
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-blue-800 dark:bg-yellow-400 text-white dark:text-blue-800 px-6 py-2 rounded-xl hover:bg-opacity-90 transition"  wire:navigate>
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="pt-24 pb-16 px-4 sm:px-6 lg:px-8 min-h-screen flex items-center">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="fade-in-up">
                    <div class="inline-block mb-4">
                        <div class="flex items-center gap-2 bg-yellow-400/40 text-blue-800 dark:text-yellow-400 border-2 border-yellow-400 px-3 py-2 rounded-full text-sm font-semibold">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center bg-yellow-400">
                                🎓
                            </div>
                            PSU San Carlos Campus
                        </div>
                    </div>
                    <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                        <span class="gradient-text">Smart Inbox</span><br>
                        <span class="text-gray-900 dark:text-white">Management System</span>
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                        Streamline communication at Pangasinan State University San Carlos Campus with AI-powered chatbot integration. Never miss an inquiry again.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="#demo" class="bg-blue-800 dark:bg-yellow-400 text-white dark:text-blue-800 px-8 py-4 rounded-lg hover:scale-105 transition font-semibold text-lg shadow-lg">
                            View Demo
                        </a>
                        <a href="#features" class="border-2 border-blue-800 dark:border-yellow-400 text-blue-800 dark:text-yellow-400 px-8 py-4 rounded-lg hover:bg-blue-800 hover:text-white dark:hover:bg-yellow-400 dark:hover:text-blue-800 transition font-semibold text-lg">
                            Learn More
                        </a>
                    </div>
                    <div class="mt-12 flex items-center space-x-8">
                        <div>
                            <p class="text-3xl font-bold text-blue-800 dark:text-yellow-400">24/7</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">AI Availability</p>
                        </div>
                        <div class="w-px h-12 bg-gray-300 dark:bg-gray-700"></div>
                        <div>
                            <p class="text-3xl font-bold text-blue-800 dark:text-yellow-400">100%</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Response Rate</p>
                        </div>
                        <div class="w-px h-12 bg-gray-300 dark:bg-gray-700"></div>
                        <div>
                            <p class="text-3xl font-bold text-blue-800 dark:text-yellow-400">Fast</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Instant Replies</p>
                        </div>
                    </div>
                </div>
                <div class="relative select-none">
                    <div class="float-animation">
                        <div class="bg-gradient-to-br from-blue-800 to-blue-600 dark:from-yellow-400 dark:to-yellow-500 rounded-2xl p-8 shadow-2xl">
                            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 mb-4">
                                <div class="flex items-center space-x-3 mb-4">
                                    <div class="w-10 h-10 bg-blue-800 dark:bg-yellow-400 rounded-full flex items-center justify-center text-2xl">
                                        🤖
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">PSU Chatbot</p>
                                        <p class="text-xs text-green-500">● Online</p>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3">
                                        <p class="text-sm text-gray-700 dark:text-gray-300">Hello! How can I help you today?</p>
                                    </div>
                                    <div class="bg-blue-800 dark:bg-yellow-400 text-white dark:text-blue-800 rounded-lg p-3 ml-8">
                                        <p class="text-sm">What are the admission requirements?</p>
                                    </div>
                                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-3">
                                        <p class="text-sm text-gray-700 dark:text-gray-300">Here are the admission requirements...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -z-10 top-10 -right-10 w-72 h-72 bg-yellow-400/20 rounded-full blur-3xl"></div>
                    <div class="absolute -z-10 -bottom-10 -left-10 w-72 h-72 bg-blue-800/20 rounded-full blur-3xl"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50 dark:bg-gray-800 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    <span class="gradient-text">Powerful Features</span>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400">Everything you need for efficient communication management</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-lg hover:shadow-2xl transition hover:scale-105">
                    <div class="w-14 h-14 bg-blue-800/10 dark:bg-yellow-400/10 rounded-lg flex items-center justify-center mb-6">
                        <span class="text-3xl">🤖</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">AI Chatbot Integration</h3>
                    <p class="text-gray-600 dark:text-gray-400">Intelligent chatbot handles common inquiries automatically, providing instant responses 24/7 to students and stakeholders.</p>
                </div>
                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-lg hover:shadow-2xl transition hover:scale-105">
                    <div class="w-14 h-14 bg-blue-800/10 dark:bg-yellow-400/10 rounded-lg flex items-center justify-center mb-6">
                        <span class="text-3xl">📊</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Centralized Dashboard</h3>
                    <p class="text-gray-600 dark:text-gray-400">Consolidate messages from Facebook, website, and other channels into one unified inbox for easy management.</p>
                </div>
                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-lg hover:shadow-2xl transition hover:scale-105">
                    <div class="w-14 h-14 bg-blue-800/10 dark:bg-yellow-400/10 rounded-lg flex items-center justify-center mb-6">
                        <span class="text-3xl">⚡</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Smart Categorization</h3>
                    <p class="text-gray-600 dark:text-gray-400">Automatically sort and prioritize messages based on content, ensuring important communications are never missed.</p>
                </div>
                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-lg hover:shadow-2xl transition hover:scale-105">
                    <div class="w-14 h-14 bg-blue-800/10 dark:bg-yellow-400/10 rounded-lg flex items-center justify-center mb-6">
                        <span class="text-3xl">📈</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Analytics & Insights</h3>
                    <p class="text-gray-600 dark:text-gray-400">Track response times, message volumes, and user satisfaction to continuously improve communication effectiveness.</p>
                </div>
                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-lg hover:shadow-2xl transition hover:scale-105">
                    <div class="w-14 h-14 bg-blue-800/10 dark:bg-yellow-400/10 rounded-lg flex items-center justify-center mb-6">
                        <span class="text-3xl">🔒</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Secure & Reliable</h3>
                    <p class="text-gray-600 dark:text-gray-400">Enterprise-grade security ensures all communications and data are protected with role-based access control.</p>
                </div>
                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-lg hover:shadow-2xl transition hover:scale-105">
                    <div class="w-14 h-14 bg-blue-800/10 dark:bg-yellow-400/10 rounded-lg flex items-center justify-center mb-6">
                        <span class="text-3xl">💬</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Multi-Channel Support</h3>
                    <p class="text-gray-600 dark:text-gray-400">Seamlessly integrate with Facebook Messenger, website forms, and other communication platforms.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl md:text-5xl font-bold mb-6">
                        <span class="gradient-text">Why Use Our System?</span>
                    </h2>
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <span class="text-blue-800 font-bold">✓</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg mb-2 text-gray-900 dark:text-white">Reduced Workload</h4>
                                <p class="text-gray-600 dark:text-gray-400">Automate responses to common queries, allowing PRIO staff to focus on complex matters.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <span class="text-blue-800 font-bold">✓</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg mb-2 text-gray-900 dark:text-white">Improved Satisfaction</h4>
                                <p class="text-gray-600 dark:text-gray-400">Instant responses and efficient handling lead to higher stakeholder satisfaction.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <span class="text-blue-800 font-bold">✓</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg mb-2 text-gray-900 dark:text-white">Enhanced Efficiency</h4>
                                <p class="text-gray-600 dark:text-gray-400">Streamlined processes mean faster response times and better resource utilization.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <span class="text-blue-800 font-bold">✓</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg mb-2 text-gray-900 dark:text-white">Data-Driven Decisions</h4>
                                <p class="text-gray-600 dark:text-gray-400">Analytics provide insights for continuous improvement of communication strategies.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-br from-blue-800 to-blue-600 dark:from-yellow-400 dark:to-yellow-500 rounded-2xl p-8 shadow-2xl">
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-6">
                            <h4 class="font-bold text-lg mb-4 text-gray-900 dark:text-white">System Statistics</h4>
                            <div class="space-y-4">
                                <div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Response Rate</span>
                                        <span class="text-sm font-bold text-blue-800 dark:text-yellow-400">100%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-blue-800 dark:bg-yellow-400 h-2 rounded-full" style="width: 100%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">User Satisfaction</span>
                                        <span class="text-sm font-bold text-blue-800 dark:text-yellow-400">95%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-blue-800 dark:bg-yellow-400 h-2 rounded-full" style="width: 95%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Efficiency Gain</span>
                                        <span class="text-sm font-bold text-blue-800 dark:text-yellow-400">80%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-blue-800 dark:bg-yellow-400 h-2 rounded-full" style="width: 80%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Demo Section -->
    <section id="demo" class="py-20 bg-gray-50 dark:bg-gray-800 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    <span class="gradient-text">See It In Action</span>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400">Experience how our system transforms communication management</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-8 max-w-5xl mx-auto">
                <div class="aspect-video bg-gradient-to-br from-blue-800/20 to-yellow-400/20 dark:from-blue-800/10 dark:to-yellow-400/10 rounded-xl flex items-center justify-center">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                            <span class="text-4xl">▶️</span>
                        </div>
                        <p class="text-xl font-semibold text-gray-900 dark:text-white">Demo Video</p>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">Click to watch the system demonstration</p>
                    </div>
                </div>
                <div class="mt-8 grid md:grid-cols-3 gap-6">
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                        <p class="text-3xl mb-2">📸</p>
                        <p class="font-semibold text-gray-900 dark:text-white">Screenshots</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">View system interface</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                        <p class="text-3xl mb-2">🎥</p>
                        <p class="font-semibold text-gray-900 dark:text-white">Tutorial</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Learn how to use it</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                        <p class="text-3xl mb-2">📱</p>
                        <p class="font-semibold text-gray-900 dark:text-white">Live Demo</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Try it yourself</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    <span class="gradient-text">Meet The Team</span>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400">The developers behind this innovative solution</p>
            </div>
            <div class="grid md:grid-cols-3 lg:mx-30">
                <div class="text-center group">
                    <div class="w-40 h-40 bg-gradient-to-br from-blue-800 to-blue-600 dark:from-yellow-400 dark:to-yellow-500 rounded-full mx-auto mb-4 flex items-center justify-center text-white dark:text-blue-800 text-3xl font-bold group-hover:scale-105 transition-all ease-in-out duration-250">
                        <img src="{{ asset('images/assets/dev me.jpg') }}" alt="" class="w-38 h-38 rounded-full object-cover">
                    </div>
                    <h4 class="font-bold text-lg text-gray-900 dark:text-white">Orland D. Sayson</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Lead Developer</p>
                    <div class="flex items-center justify-center gap-2 text-3xl mt-1">
                        <i class="fa-brands fa-square-facebook text-blue-600"></i>
                        <i class="fa-brands fa-square-linkedin text-blue-700"></i>
                        <i class="fa-brands fa-square-instagram text-[#da365b]"></i>
                    </div>
                </div>
                <div class="text-center group">
                    <div class="w-40 h-40 bg-gradient-to-br from-blue-800 to-blue-600 dark:from-yellow-400 dark:to-yellow-500 rounded-full mx-auto mb-4 flex items-center justify-center text-white dark:text-blue-800 text-3xl font-bold group-hover:scale-105 transition-all ease-in-out duration-250">
                        <img src="{{ asset('images/assets/dev vero.jpg') }}" alt="" class="w-38 h-38 rounded-full object-cover">
                    </div>
                    <h4 class="font-bold text-lg text-gray-900 dark:text-white">Angeline R. Dalisay</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Researcher</p>
                    <div class="flex items-center justify-center gap-2 text-3xl mt-1">
                        <i class="fa-brands fa-square-facebook text-blue-600"></i>
                        <i class="fa-brands fa-square-linkedin text-blue-700"></i>
                        <i class="fa-brands fa-square-instagram text-[#da365b]"></i>
                    </div>
                </div>
                <div class="text-center group">
                    <div class="w-40 h-40 bg-gradient-to-br from-blue-800 to-blue-600 dark:from-yellow-400 dark:to-yellow-500 rounded-full mx-auto mb-4 flex items-center justify-center text-white dark:text-blue-800 text-3xl font-bold group-hover:scale-105 transition-all ease-in-out duration-250">
                        <img src="{{ asset('images/assets/dev bur.jpg') }}" alt="" class="w-38 h-38 rounded-full object-cover">
                    </div>
                    <h4 class="font-bold text-lg text-gray-900 dark:text-white">Wilbur V. Grefaldo</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Researcher</p>
                    <div class="flex items-center justify-center gap-2 text-3xl mt-1">
                        <i class="fa-brands fa-square-facebook text-blue-600"></i>
                        <i class="fa-brands fa-square-linkedin text-blue-700"></i>
                        <i class="fa-brands fa-square-instagram text-[#da365b]"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact/CTA Section -->
    <section id="contact" class="py-20 bg-gradient-to-br from-blue-800 to-blue-600 dark:from-gray-900 dark:to-gray-800 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-6 text-white">
                Ready to Transform Your Communication?
            </h2>
            <p class="text-xl text-blue-100 dark:text-gray-400 mb-8">
                Join PSU San Carlos Campus in revolutionizing stakeholder engagement
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                @auth
                    <a href="#login" class="bg-yellow-400 text-blue-800 px-8 py-4 rounded-lg hover:scale-105 transition font-semibold text-lg shadow-lg">
                        Go to my Dashboard
                    </a>
                @else
                    <a href="#login" class="bg-yellow-400 text-blue-800 px-8 py-4 rounded-lg hover:scale-105 transition font-semibold text-lg shadow-lg">
                        Get Started Now
                    </a>
                @endauth
                <a href="mailto:prio@psu.edu.ph" class="bg-white/10 backdrop-blur-sm text-white border-2 border-white px-8 py-4 rounded-lg hover:bg-white/20 transition font-semibold text-lg">
                    Contact PRIO
                </a>
            </div>
            <div class="mt-12 pt-12 border-t border-white/20">
                <p class="text-blue-100 dark:text-gray-400 mb-4">
                    Pangasinan State University - San Carlos Campus
                </p>
                <p class="text-blue-200 dark:text-gray-500 text-sm">
                    ©{{ now()->format('Y') }} {{ config('app.name') }}. All rights reserved.
                </p>
            </div>
        </div>
    </section>

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Add scroll animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('section').forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(30px)';
            section.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
            observer.observe(section);
        });
    </script>
</body>
</html>