import React from 'react';
import { Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface Props {
    auth?: {
        user: {
            name: string;
            email: string;
            role: string;
        };
    };
    [key: string]: unknown;
}

export default function Welcome({ auth }: Props) {
    return (
        <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
            {/* Navigation */}
            <nav className="bg-white/80 backdrop-blur-sm border-b border-gray-200 sticky top-0 z-50">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between items-center h-16">
                        <div className="flex items-center space-x-2">
                            <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                <span className="text-white font-bold text-sm">🚔</span>
                            </div>
                            <h1 className="text-xl font-bold text-gray-900">Police Service Portal</h1>
                        </div>
                        
                        <div className="flex items-center space-x-4">
                            {auth?.user ? (
                                <div className="flex items-center space-x-4">
                                    <span className="text-sm text-gray-700">Welcome, {auth.user.name}</span>
                                    <Link href="/dashboard">
                                        <Button variant="default">Dashboard</Button>
                                    </Link>
                                </div>
                            ) : (
                                <div className="flex items-center space-x-3">
                                    <Link href="/login">
                                        <Button variant="outline">Sign In</Button>
                                    </Link>
                                    <Link href="/register">
                                        <Button>Get Started</Button>
                                    </Link>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </nav>

            {/* Hero Section */}
            <section className="py-20 px-4 sm:px-6 lg:px-8">
                <div className="max-w-7xl mx-auto text-center">
                    <div className="mb-8">
                        <div className="inline-flex items-center justify-center w-24 h-24 bg-blue-100 rounded-full mb-6">
                            <span className="text-4xl">🏛️</span>
                        </div>
                    </div>
                    
                    <h1 className="text-5xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                        Police Service Portal
                        <br />
                        <span className="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            Management System
                        </span>
                    </h1>
                    
                    <p className="text-xl text-gray-600 mb-8 max-w-3xl mx-auto leading-relaxed">
                        Streamline law enforcement operations with our comprehensive case management 
                        and personnel tracking system. Built for modern police departments.
                    </p>
                    
                    {!auth?.user && (
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            <Link href="/register">
                                <Button size="lg" className="px-8 py-4 text-lg">
                                    🚀 Get Started Free
                                </Button>
                            </Link>
                            <Link href="/login">
                                <Button variant="outline" size="lg" className="px-8 py-4 text-lg">
                                    👮 Officer Login
                                </Button>
                            </Link>
                        </div>
                    )}
                </div>
            </section>

            {/* Features Grid */}
            <section className="py-20 bg-white">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="text-center mb-16">
                        <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                            ⚡ Powerful Features
                        </h2>
                        <p className="text-xl text-gray-600 max-w-2xl mx-auto">
                            Everything you need to manage cases and personnel efficiently
                        </p>
                    </div>
                    
                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {/* Case Management */}
                        <div className="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-8 border border-blue-100">
                            <div className="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mb-4">
                                <span className="text-white text-2xl">📋</span>
                            </div>
                            <h3 className="text-xl font-bold text-gray-900 mb-3">Case Management</h3>
                            <p className="text-gray-600 mb-4">
                                Complete CRUD operations for case data with advanced filtering, 
                                sorting, and search capabilities.
                            </p>
                            <ul className="text-sm text-gray-600 space-y-1">
                                <li>• Track case status and priority</li>
                                <li>• Assign officers to cases</li>
                                <li>• Upload evidence files</li>
                                <li>• Generate case reports</li>
                            </ul>
                        </div>

                        {/* Personnel Management */}
                        <div className="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-8 border border-green-100">
                            <div className="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mb-4">
                                <span className="text-white text-2xl">👥</span>
                            </div>
                            <h3 className="text-xl font-bold text-gray-900 mb-3">Personnel Records</h3>
                            <p className="text-gray-600 mb-4">
                                Comprehensive officer database with detailed profiles, 
                                ranks, departments, and document management.
                            </p>
                            <ul className="text-sm text-gray-600 space-y-1">
                                <li>• Officer profiles & badges</li>
                                <li>• Department assignments</li>
                                <li>• Document uploads</li>
                                <li>• Emergency contacts</li>
                            </ul>
                        </div>

                        {/* Security & Access */}
                        <div className="bg-gradient-to-br from-purple-50 to-violet-50 rounded-xl p-8 border border-purple-100">
                            <div className="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mb-4">
                                <span className="text-white text-2xl">🔐</span>
                            </div>
                            <h3 className="text-xl font-bold text-gray-900 mb-3">Role-Based Security</h3>
                            <p className="text-gray-600 mb-4">
                                Multi-level authentication system with admin, officer, 
                                and user roles for secure access control.
                            </p>
                            <ul className="text-sm text-gray-600 space-y-1">
                                <li>• Admin dashboard access</li>
                                <li>• Officer-specific views</li>
                                <li>• Secure file handling</li>
                                <li>• Activity logging</li>
                            </ul>
                        </div>

                        {/* File Management */}
                        <div className="bg-gradient-to-br from-orange-50 to-amber-50 rounded-xl p-8 border border-orange-100">
                            <div className="w-12 h-12 bg-orange-600 rounded-lg flex items-center justify-center mb-4">
                                <span className="text-white text-2xl">📁</span>
                            </div>
                            <h3 className="text-xl font-bold text-gray-900 mb-3">File Upload System</h3>
                            <p className="text-gray-600 mb-4">
                                Secure file upload and management for case evidence 
                                and personnel documents.
                            </p>
                            <ul className="text-sm text-gray-600 space-y-1">
                                <li>• Evidence photo uploads</li>
                                <li>• Document attachments</li>
                                <li>• File type validation</li>
                                <li>• Secure storage</li>
                            </ul>
                        </div>

                        {/* Search & Filter */}
                        <div className="bg-gradient-to-br from-red-50 to-pink-50 rounded-xl p-8 border border-red-100">
                            <div className="w-12 h-12 bg-red-600 rounded-lg flex items-center justify-center mb-4">
                                <span className="text-white text-2xl">🔍</span>
                            </div>
                            <h3 className="text-xl font-bold text-gray-900 mb-3">Advanced Search</h3>
                            <p className="text-gray-600 mb-4">
                                Powerful search and filtering capabilities to quickly 
                                find cases and personnel records.
                            </p>
                            <ul className="text-sm text-gray-600 space-y-1">
                                <li>• Multi-field search</li>
                                <li>• Smart filtering</li>
                                <li>• Custom sorting</li>
                                <li>• Quick access</li>
                            </ul>
                        </div>

                        {/* Mobile Responsive */}
                        <div className="bg-gradient-to-br from-teal-50 to-cyan-50 rounded-xl p-8 border border-teal-100">
                            <div className="w-12 h-12 bg-teal-600 rounded-lg flex items-center justify-center mb-4">
                                <span className="text-white text-2xl">📱</span>
                            </div>
                            <h3 className="text-xl font-bold text-gray-900 mb-3">Mobile Ready</h3>
                            <p className="text-gray-600 mb-4">
                                Fully responsive design that works perfectly on 
                                desktop, tablet, and mobile devices.
                            </p>
                            <ul className="text-sm text-gray-600 space-y-1">
                                <li>• Mobile-first design</li>
                                <li>• Touch-friendly interface</li>
                                <li>• Offline capabilities</li>
                                <li>• Cross-platform support</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            {/* CTA Section */}
            {!auth?.user && (
                <section className="py-20 bg-gradient-to-r from-blue-600 to-indigo-600">
                    <div className="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                        <h2 className="text-3xl md:text-4xl font-bold text-white mb-6">
                            🚀 Ready to Modernize Your Department?
                        </h2>
                        <p className="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                            Join law enforcement agencies who trust our platform to 
                            streamline their operations and improve public safety.
                        </p>
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            <Link href="/register">
                                <Button size="lg" variant="secondary" className="px-8 py-4 text-lg">
                                    🎯 Start Free Trial
                                </Button>
                            </Link>
                            <Link href="/login">
                                <Button size="lg" variant="outline" className="px-8 py-4 text-lg border-white text-white hover:bg-white hover:text-blue-600">
                                    👮 Officer Portal
                                </Button>
                            </Link>
                        </div>
                    </div>
                </section>
            )}

            {/* Footer */}
            <footer className="bg-gray-900 text-white py-12">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex flex-col md:flex-row justify-between items-center">
                        <div className="flex items-center space-x-2 mb-4 md:mb-0">
                            <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                <span className="text-white font-bold text-sm">🚔</span>
                            </div>
                            <span className="text-xl font-bold">Police Service Portal</span>
                        </div>
                        
                        <div className="text-sm text-gray-400 text-center md:text-right">
                            <p>© 2024 Police Service Portal. All rights reserved.</p>
                            <p className="mt-1">Built with Laravel & React for law enforcement excellence.</p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    );
}