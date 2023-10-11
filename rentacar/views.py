from django.shortcuts import render, redirect
from django.contrib.auth import login, logout
from django.contrib.auth.views import LoginView
from django.contrib import messages
from django.contrib.auth.models import User
from django.urls import reverse_lazy

# Remove the login_page view

def home(request):
    return render(request, 'RentACar/index.html')

def about_us(request):
    return render(request, 'RentACar/about-us.html')

def contact_us(request):
    return render(request, 'RentACar/contact.html')

class CustomLoginView(LoginView):
    template_name = 'RentACar/login.html'  # Your login template
    redirect_authenticated_user = True  # Redirect authenticated users away from login page
    success_url = reverse_lazy('homepage')  # Specify the URL to redirect to upon successful login

    def get_success_url(self):
        return self.success_url

def register(request):
    if request.method == 'POST':
        first_name = request.POST.get('fname')
        last_name = request.POST.get('lname')
        username = request.POST.get('username')
        password = request.POST.get('password')
        user = User.objects.create_user(username=username, password=password, first_name=first_name, last_name=last_name)
        user.save()
        return redirect('login')
    return render(request, 'RentACar/register.html')

def logout_view(request):
    logout(request)
    return redirect('login')

def homepage(request):
    return render(request, 'RentACar/homepage.html')
