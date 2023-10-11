from django import forms
from django.contrib.auth.forms import UserCreationForm, AuthenticationForm

class RegisterForm(UserCreationForm):
    pass  # Add any additional fields if needed

class LoginForm(AuthenticationForm):
    pass
