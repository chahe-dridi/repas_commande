﻿using System;
using System.Collections.Generic;
using System.Configuration;
using System.Data;
using System.Linq;
using System.Threading;
using System.Threading.Tasks;
using System.Windows;

namespace FoodRecipes
{
	/// <summary>
	/// Interaction logic for App.xaml
	/// </summary>
	public partial class App : Application
	{
		public App()
		{
			//Thread.CurrentThread.CurrentUICulture = new System.Globalization.CultureInfo("vi");
			InitializeComponent();

		}
	}
}
