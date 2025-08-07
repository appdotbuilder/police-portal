import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

interface DashboardCase {
    id: number;
    case_number: string;
    title: string;
    status: string;
    priority: string;
    created_at: string;
    assigned_officer?: {
        name: string;
    };
}

interface Props {
    stats: {
        totalCases: number;
        openCases: number;
        highPriorityCases: number;
        totalPersonnel: number;
    };
    recentCases: DashboardCase[];
    casesByStatus: Record<string, number>;
    casesByPriority: Record<string, number>;
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const statusColors: Record<string, string> = {
    open: 'bg-red-500',
    in_progress: 'bg-yellow-500',
    closed: 'bg-green-500',
    archived: 'bg-gray-500',
};

const priorityColors: Record<string, string> = {
    low: 'bg-blue-500',
    medium: 'bg-yellow-500',
    high: 'bg-orange-500',
    critical: 'bg-red-500',
};

export default function Dashboard({ stats, recentCases, casesByStatus }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            
            <div className="p-6 space-y-6">
                {/* Welcome Header */}
                <div className="mb-8">
                    <h1 className="text-3xl font-bold text-gray-900 mb-2">
                        🚔 Police Service Portal Dashboard
                    </h1>
                    <p className="text-gray-600">
                        Monitor cases, manage personnel, and oversee department operations
                    </p>
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <Card className="bg-gradient-to-br from-blue-50 to-blue-100 border-blue-200">
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium text-blue-800">
                                Total Cases
                            </CardTitle>
                            <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                <span className="text-white text-sm">📋</span>
                            </div>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-blue-900">{stats.totalCases}</div>
                            <p className="text-xs text-blue-700 mt-1">
                                All cases in system
                            </p>
                        </CardContent>
                    </Card>

                    <Card className="bg-gradient-to-br from-red-50 to-red-100 border-red-200">
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium text-red-800">
                                Open Cases
                            </CardTitle>
                            <div className="w-8 h-8 bg-red-600 rounded-lg flex items-center justify-center">
                                <span className="text-white text-sm">🚨</span>
                            </div>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-red-900">{stats.openCases}</div>
                            <p className="text-xs text-red-700 mt-1">
                                Require attention
                            </p>
                        </CardContent>
                    </Card>

                    <Card className="bg-gradient-to-br from-orange-50 to-orange-100 border-orange-200">
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium text-orange-800">
                                High Priority
                            </CardTitle>
                            <div className="w-8 h-8 bg-orange-600 rounded-lg flex items-center justify-center">
                                <span className="text-white text-sm">⚡</span>
                            </div>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-orange-900">{stats.highPriorityCases}</div>
                            <p className="text-xs text-orange-700 mt-1">
                                Critical & high cases
                            </p>
                        </CardContent>
                    </Card>

                    <Card className="bg-gradient-to-br from-green-50 to-green-100 border-green-200">
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium text-green-800">
                                Active Personnel
                            </CardTitle>
                            <div className="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
                                <span className="text-white text-sm">👮</span>
                            </div>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-green-900">{stats.totalPersonnel}</div>
                            <p className="text-xs text-green-700 mt-1">
                                Officers on duty
                            </p>
                        </CardContent>
                    </Card>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {/* Recent Cases */}
                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between">
                            <CardTitle className="text-lg font-semibold">
                                📋 Recent Cases
                            </CardTitle>
                            <Link href="/cases">
                                <Button variant="outline" size="sm">
                                    View All
                                </Button>
                            </Link>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {recentCases.map((case_) => (
                                    <div key={case_.id} className="flex items-start justify-between p-4 border rounded-lg">
                                        <div className="flex-1">
                                            <div className="flex items-center gap-2 mb-1">
                                                <span className="font-medium text-sm text-blue-600">
                                                    {case_.case_number}
                                                </span>
                                                <span className={`w-2 h-2 rounded-full ${statusColors[case_.status]}`}></span>
                                                <span className="text-xs text-gray-500 capitalize">
                                                    {case_.status.replace('_', ' ')}
                                                </span>
                                            </div>
                                            <h4 className="font-medium text-gray-900 mb-1">
                                                {case_.title}
                                            </h4>
                                            <p className="text-sm text-gray-600">
                                                {case_.assigned_officer ? 
                                                    `Assigned to: ${case_.assigned_officer.name}` : 
                                                    'Unassigned'
                                                }
                                            </p>
                                        </div>
                                        <div className="text-right">
                                            <span className={`px-2 py-1 text-xs rounded-full text-white ${priorityColors[case_.priority]}`}>
                                                {case_.priority}
                                            </span>
                                            <p className="text-xs text-gray-500 mt-1">
                                                {new Date(case_.created_at).toLocaleDateString()}
                                            </p>
                                        </div>
                                    </div>
                                ))}
                                {recentCases.length === 0 && (
                                    <p className="text-center text-gray-500 py-8">
                                        No recent cases found
                                    </p>
                                )}
                            </div>
                        </CardContent>
                    </Card>

                    {/* Quick Actions & Stats */}
                    <div className="space-y-6">
                        {/* Quick Actions */}
                        <Card>
                            <CardHeader>
                                <CardTitle className="text-lg font-semibold">
                                    ⚡ Quick Actions
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="grid grid-cols-1 gap-3">
                                    <Link href="/cases/create">
                                        <Button className="w-full justify-start" variant="outline">
                                            <span className="mr-2">➕</span>
                                            Create New Case
                                        </Button>
                                    </Link>
                                    <Link href="/personnel/create">
                                        <Button className="w-full justify-start" variant="outline">
                                            <span className="mr-2">👤</span>
                                            Add Personnel
                                        </Button>
                                    </Link>
                                    <Link href="/cases?status=open">
                                        <Button className="w-full justify-start" variant="outline">
                                            <span className="mr-2">🔍</span>
                                            View Open Cases
                                        </Button>
                                    </Link>
                                    <Link href="/personnel">
                                        <Button className="w-full justify-start" variant="outline">
                                            <span className="mr-2">👥</span>
                                            Manage Personnel
                                        </Button>
                                    </Link>
                                </div>
                            </CardContent>
                        </Card>

                        {/* Case Status Distribution */}
                        <Card>
                            <CardHeader>
                                <CardTitle className="text-lg font-semibold">
                                    📊 Case Status Overview
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="space-y-3">
                                    {Object.entries(casesByStatus).map(([status, count]) => (
                                        <div key={status} className="flex items-center justify-between">
                                            <div className="flex items-center gap-2">
                                                <span className={`w-3 h-3 rounded-full ${statusColors[status]}`}></span>
                                                <span className="text-sm font-medium capitalize">
                                                    {status.replace('_', ' ')}
                                                </span>
                                            </div>
                                            <span className="text-sm font-bold">{count}</span>
                                        </div>
                                    ))}
                                </div>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}