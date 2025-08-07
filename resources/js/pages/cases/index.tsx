import { useState } from 'react';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Badge } from '@/components/ui/badge';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/react';

interface CaseData {
    id: number;
    case_number: string;
    title: string;
    description: string;
    status: string;
    priority: string;
    category: string;
    location: string | null;
    incident_date: string | null;
    created_at: string;
    assigned_officer?: {
        name: string;
    };
    creator: {
        name: string;
    };
}

interface Officer {
    id: number;
    name: string;
}

interface Props {
    cases: {
        data: CaseData[];
        links: Array<{
            url: string | null;
            label: string;
            active: boolean;
        }>;
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    officers: Officer[];
    filters: {
        status?: string;
        priority?: string;
        category?: string;
        search?: string;
        sort_by?: string;
        sort_order?: string;
    };
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Cases', href: '/cases' },
];

const statusColors: Record<string, string> = {
    open: 'bg-red-100 text-red-800 border-red-200',
    in_progress: 'bg-yellow-100 text-yellow-800 border-yellow-200',
    closed: 'bg-green-100 text-green-800 border-green-200',
    archived: 'bg-gray-100 text-gray-800 border-gray-200',
};

const priorityColors: Record<string, string> = {
    low: 'bg-blue-100 text-blue-800 border-blue-200',
    medium: 'bg-yellow-100 text-yellow-800 border-yellow-200',
    high: 'bg-orange-100 text-orange-800 border-orange-200',
    critical: 'bg-red-100 text-red-800 border-red-200',
};

export default function CasesIndex({ cases, filters }: Props) {
    const [searchTerm, setSearchTerm] = useState(filters.search || '');
    const [statusFilter, setStatusFilter] = useState(filters.status || '');
    const [priorityFilter, setPriorityFilter] = useState(filters.priority || '');
    const [categoryFilter, setCategoryFilter] = useState(filters.category || '');

    const handleSearch = () => {
        router.get('/cases', {
            search: searchTerm,
            status: statusFilter,
            priority: priorityFilter,
            category: categoryFilter,
        }, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const clearFilters = () => {
        setSearchTerm('');
        setStatusFilter('');
        setPriorityFilter('');
        setCategoryFilter('');
        router.get('/cases');
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Case Management" />
            
            <div className="p-6 space-y-6">
                {/* Header */}
                <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900 flex items-center gap-2">
                            📋 Case Management
                        </h1>
                        <p className="text-gray-600 mt-1">
                            Manage and track all police cases
                        </p>
                    </div>
                    <Link href="/cases/create">
                        <Button className="bg-blue-600 hover:bg-blue-700">
                            <span className="mr-2">➕</span>
                            New Case
                        </Button>
                    </Link>
                </div>

                {/* Search and Filters */}
                <Card>
                    <CardHeader>
                        <CardTitle className="text-lg">🔍 Search & Filter</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                            <div>
                                <Input
                                    placeholder="Search cases..."
                                    value={searchTerm}
                                    onChange={(e) => setSearchTerm(e.target.value)}
                                    onKeyPress={(e) => e.key === 'Enter' && handleSearch()}
                                />
                            </div>
                            
                            <div>
                                <Select value={statusFilter} onValueChange={setStatusFilter}>
                                    <SelectTrigger>
                                        <SelectValue placeholder="Filter by status" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="">All Statuses</SelectItem>
                                        <SelectItem value="open">Open</SelectItem>
                                        <SelectItem value="in_progress">In Progress</SelectItem>
                                        <SelectItem value="closed">Closed</SelectItem>
                                        <SelectItem value="archived">Archived</SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                            
                            <div>
                                <Select value={priorityFilter} onValueChange={setPriorityFilter}>
                                    <SelectTrigger>
                                        <SelectValue placeholder="Filter by priority" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="">All Priorities</SelectItem>
                                        <SelectItem value="low">Low</SelectItem>
                                        <SelectItem value="medium">Medium</SelectItem>
                                        <SelectItem value="high">High</SelectItem>
                                        <SelectItem value="critical">Critical</SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                            
                            <div>
                                <Select value={categoryFilter} onValueChange={setCategoryFilter}>
                                    <SelectTrigger>
                                        <SelectValue placeholder="Filter by category" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="">All Categories</SelectItem>
                                        <SelectItem value="theft">Theft</SelectItem>
                                        <SelectItem value="assault">Assault</SelectItem>
                                        <SelectItem value="fraud">Fraud</SelectItem>
                                        <SelectItem value="traffic">Traffic</SelectItem>
                                        <SelectItem value="domestic">Domestic</SelectItem>
                                        <SelectItem value="drug">Drug</SelectItem>
                                        <SelectItem value="cybercrime">Cybercrime</SelectItem>
                                        <SelectItem value="other">Other</SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                            
                            <div className="flex gap-2">
                                <Button onClick={handleSearch} variant="outline">
                                    Search
                                </Button>
                                <Button onClick={clearFilters} variant="outline">
                                    Clear
                                </Button>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                {/* Cases List */}
                <Card>
                    <CardHeader>
                        <CardTitle className="flex items-center justify-between">
                            <span>📊 Cases ({cases.total})</span>
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="space-y-4">
                            {cases.data.map((case_) => (
                                <div key={case_.id} className="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div className="flex flex-col sm:flex-row justify-between items-start gap-4">
                                        <div className="flex-1 space-y-2">
                                            <div className="flex items-center gap-2 flex-wrap">
                                                <Link 
                                                    href={`/cases/${case_.id}`}
                                                    className="font-semibold text-blue-600 hover:text-blue-800"
                                                >
                                                    {case_.case_number}
                                                </Link>
                                                <Badge className={statusColors[case_.status]}>
                                                    {case_.status.replace('_', ' ')}
                                                </Badge>
                                                <Badge className={priorityColors[case_.priority]}>
                                                    {case_.priority}
                                                </Badge>
                                            </div>
                                            
                                            <h3 className="font-medium text-gray-900">{case_.title}</h3>
                                            
                                            <p className="text-sm text-gray-600 line-clamp-2">
                                                {case_.description}
                                            </p>
                                            
                                            <div className="flex flex-wrap gap-4 text-sm text-gray-500">
                                                <span>📍 {case_.location || 'No location'}</span>
                                                <span>👮 {case_.assigned_officer?.name || 'Unassigned'}</span>
                                                <span>📅 {new Date(case_.created_at).toLocaleDateString()}</span>
                                            </div>
                                        </div>
                                        
                                        <div className="flex gap-2">
                                            <Link href={`/cases/${case_.id}`}>
                                                <Button variant="outline" size="sm">
                                                    View
                                                </Button>
                                            </Link>
                                            <Link href={`/cases/${case_.id}/edit`}>
                                                <Button variant="outline" size="sm">
                                                    Edit
                                                </Button>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            ))}
                            
                            {cases.data.length === 0 && (
                                <div className="text-center py-12">
                                    <div className="text-6xl mb-4">📋</div>
                                    <h3 className="text-lg font-medium text-gray-900 mb-2">No cases found</h3>
                                    <p className="text-gray-600 mb-6">
                                        {searchTerm || statusFilter || priorityFilter || categoryFilter 
                                            ? 'Try adjusting your search filters'
                                            : 'Start by creating your first case'
                                        }
                                    </p>
                                    {!(searchTerm || statusFilter || priorityFilter || categoryFilter) && (
                                        <Link href="/cases/create">
                                            <Button>Create First Case</Button>
                                        </Link>
                                    )}
                                </div>
                            )}
                        </div>
                        
                        {/* Pagination */}
                        {cases.last_page > 1 && (
                            <div className="mt-6 flex justify-center">
                                <div className="flex items-center gap-2">
                                    {cases.links.map((link, index) => (
                                        <Button
                                            key={index}
                                            variant={link.active ? "default" : "outline"}
                                            size="sm"
                                            disabled={!link.url}
                                            onClick={() => link.url && router.get(link.url)}
                                            dangerouslySetInnerHTML={{ __html: link.label }}
                                        />
                                    ))}
                                </div>
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}