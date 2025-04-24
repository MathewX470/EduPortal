<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduPortal - Academic Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        :where([class^="ri-"])::before {
            content: "\f3c2";
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        #supp {
            position: absolute;
            right: 10%;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4F46E5',
                        secondary: '#0EA5E9'
                    },
                    borderRadius: {
                        'none': '0px',
                        'sm': '4px',
                        DEFAULT: '8px',
                        'md': '12px',
                        'lg': '16px',
                        'xl': '20px',
                        '2xl': '24px',
                        '3xl': '32px',
                        'full': '9999px',
                        'button': '8px'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-white">
    <header class="fixed top-0 left-0 right-0 bg-white shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="#" class="text-2xl font-['Pacifico'] text-primary">EduPortal</a>
                </div>
                <nav class="hidden md:flex space-x-8">
                    <a href="#home" class="text-gray-700 hover:text-primary px-3 py-2 text-sm font-medium">Home</a>
                    <a href="#features" class="text-gray-700 hover:text-primary px-3 py-2 text-sm font-medium">Features</a>
                    <a href="#roles" class="text-gray-700 hover:text-primary px-3 py-2 text-sm font-medium">Roles</a>
                    <a href="#supp" class="text-gray-700 hover:text-primary px-3 py-2 text-sm font-medium">Contact</a>
                </nav>
                <div class="flex items-center">
                <button class="text-primary hover:text-primary/80 px-4 py-2 text-sm font-medium !rounded-button whitespace-nowrap" onclick="window.location.href='login.php'">Log In</button>
                <button class="bg-primary text-white hover:bg-primary/90 px-4 py-2 text-sm font-medium !rounded-button whitespace-nowrap" onclick="window.location.href='signup.php'">Sign Up</button>
                </div>
            </div>
        </div>
    </header>
    <main class="pt-16">
        <section id="home" class="relative bg-gradient-to-r from-gray-50 to-white overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="text-left">
                        <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6">Welcome to EduPortal</h1>
                        <p class="text-xl text-gray-600 mb-12">Comprehensive Academic Management System designed to streamline education processes and enhance learning experiences.</p>
                    </div>
                    <div class="relative">
                        <img src="https://public.readdy.ai/ai/img_res/bb88405bbcf5da9ffcf77ba4cbcf21f1.jpg" alt="Modern Education Environment" class="rounded-lg shadow-xl">
                    </div>
                </div>
            </div>
        </section>
        <section id="features" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-16">Core Features</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-6 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mb-4">
                            <i class="ri-calendar-check-line text-primary text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Attendance Tracking</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-center">
                                <i class="ri-checkbox-circle-line text-primary mr-2"></i>
                                Real-time attendance status
                            </li>
                            <li class="flex items-center">
                                <i class="ri-checkbox-circle-line text-primary mr-2"></i>
                                Detailed attendance reports
                            </li>
                        </ul>
                    </div>
                    <div class="p-6 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 bg-secondary/10 rounded-full flex items-center justify-center mb-4">
                            <i class="ri-file-chart-line text-secondary text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Exam Results</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-center">
                                <i class="ri-checkbox-circle-line text-secondary mr-2"></i>
                                Semester results
                            </li>
                            <li class="flex items-center">
                                <i class="ri-checkbox-circle-line text-secondary mr-2"></i>
                                Performance analytics
                            </li>
                            <li class="flex items-center">
                                <i class="ri-checkbox-circle-line text-secondary mr-2"></i>
                                Grade history
                            </li>
                        </ul>
                    </div>
                    <div class="p-6 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mb-4">
                            <i class="ri-file-paper-2-line text-primary text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Leave Application</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-center">
                                <i class="ri-checkbox-circle-line text-primary mr-2"></i>
                                Easy submission
                            </li>
                            <li class="flex items-center">
                                <i class="ri-checkbox-circle-line text-primary mr-2"></i>
                                Status tracking
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section id="roles" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-16">User Roles</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mb-4">
                            <i class="ri-user-line text-primary text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Students</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-center">
                                <i class="ri-checkbox-circle-line text-primary mr-2"></i>
                                View attendance
                            </li>
                            <li class="flex items-center">
                                <i class="ri-checkbox-circle-line text-primary mr-2"></i>
                                Check results
                            </li>
                            <li class="flex items-center">
                                <i class="ri-checkbox-circle-line text-primary mr-2"></i>
                                Submit leave applications
                            </li>
                        </ul>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 bg-secondary/10 rounded-full flex items-center justify-center mb-4">
                            <i class="ri-parent-line text-secondary text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Parents</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-center">
                                <i class="ri-checkbox-circle-line text-secondary mr-2"></i>
                                Monitor attendance
                            </li>
                            <li class="flex items-center">
                                <i class="ri-checkbox-circle-line text-secondary mr-2"></i>
                                Track performance
                            </li>

                        </ul>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mb-4">
                            <i class="ri-team-line text-primary text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Faculty</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-center">
                                <i class="ri-checkbox-circle-line text-primary mr-2"></i>
                                Mark attendance
                            </li>
                            <li class="flex items-center">
                                <i class="ri-checkbox-circle-line text-primary mr-2"></i>
                                Upload results
                            </li>
                            <li class="flex items-center">
                                <i class="ri-checkbox-circle-line text-primary mr-2"></i>
                                Approve leaves
                            </li>
                        </ul>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 bg-secondary/10 rounded-full flex items-center justify-center mb-4">
                            <i class="ri-admin-line text-secondary text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Administrators</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-center">
                                <i class="ri-checkbox-circle-line text-secondary mr-2"></i>
                                System management
                            </li>
                            <li class="flex items-center">
                                <i class="ri-checkbox-circle-line text-secondary mr-2"></i>
                                User administration
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!--section id="contact" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-16">Contact Us</h2>
                <div class="max-w-3xl mx-auto">
                    <form class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" id="name" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm" required>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm" required>
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                            <textarea id="message" name="message" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm" required></textarea>
                        </div>
                        <div>
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </section-->
    </main>
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="space-y-4">
                    <a href="#" class="text-2xl font-['Pacifico'] text-white">EduPortal</a>
                    <p class="text-gray-400">Empowering education through innovative technology solutions.</p>
                </div>

                <div id="supp">
                    <h4 class="text-lg font-semibold mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center text-gray-400">
                            <i class="ri-mail-line mr-2"></i>
                            support@eduportal.com
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i class="ri-phone-line mr-2"></i>
                            +1 (555) 123-4567
                        </li>
                    </ul>
                </div>

            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; 2025 EduPortal. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            console.log('Form submitted:', data);
            this.reset();
            const notification = document.createElement('div');
            notification.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg';
            notification.textContent = 'Message sent successfully!';
            document.body.appendChild(notification);
            setTimeout(() => {
                notification.remove();
            }, 3000);
        });
    </script>
</body>

</html>