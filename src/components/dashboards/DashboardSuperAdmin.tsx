import { StatCard } from "@/components/StatCard";
import { Card } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Building2, Users, DollarSign, Activity } from "lucide-react";
import { superAdminData } from "@/data/seeders";
import {
  BarChart, Bar, XAxis, YAxis, CartesianGrid, Tooltip,
  ResponsiveContainer, PieChart, Pie, Cell,
} from "recharts";

const icons = [Building2, Users, DollarSign, Activity];

export function DashboardSuperAdmin() {
  const d = superAdminData;

  return (
    <div className="space-y-6 max-w-7xl">
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {d.kpis.map((kpi, i) => {
          const Icon = icons[i];
          return (
            <StatCard key={kpi.title} title={kpi.title} value={kpi.value} change={kpi.change} changeType={kpi.changeType} icon={<Icon className="h-5 w-5" />} />
          );
        })}
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <Card className="col-span-1 lg:col-span-2 p-5">
          <h3 className="text-sm font-semibold text-card-foreground mb-4">Receita MRR Mensal</h3>
          <ResponsiveContainer width="100%" height={260}>
            <BarChart data={d.revenueChart}>
              <CartesianGrid strokeDasharray="3 3" stroke="hsl(var(--border))" />
              <XAxis dataKey="name" tick={{ fontSize: 12 }} stroke="hsl(var(--muted-foreground))" />
              <YAxis tick={{ fontSize: 12 }} stroke="hsl(var(--muted-foreground))" />
              <Tooltip formatter={(value: number) => [`R$ ${value.toLocaleString("pt-BR")}`, "MRR"]} contentStyle={{ borderRadius: 8, fontSize: 12 }} />
              <Bar dataKey="valor" fill="hsl(var(--primary))" radius={[4, 4, 0, 0]} />
            </BarChart>
          </ResponsiveContainer>
        </Card>

        <Card className="p-5">
          <h3 className="text-sm font-semibold text-card-foreground mb-4">Distribuição de Planos</h3>
          <ResponsiveContainer width="100%" height={200}>
            <PieChart>
              <Pie data={d.planoDistribuicao} cx="50%" cy="50%" innerRadius={50} outerRadius={80} dataKey="value" stroke="none">
                {d.planoDistribuicao.map((entry, i) => (
                  <Cell key={i} fill={entry.color} />
                ))}
              </Pie>
              <Tooltip contentStyle={{ borderRadius: 8, fontSize: 12 }} />
            </PieChart>
          </ResponsiveContainer>
          <div className="grid grid-cols-2 gap-2 mt-2">
            {d.planoDistribuicao.map((s) => (
              <div key={s.name} className="flex items-center gap-2">
                <div className="h-2 w-2 rounded-full" style={{ backgroundColor: s.color }} />
                <span className="text-xs text-muted-foreground">{s.name} ({s.value})</span>
              </div>
            ))}
          </div>
        </Card>
      </div>

      <Card className="p-5">
        <h3 className="text-sm font-semibold text-card-foreground mb-4">Sindicatos (Tenants)</h3>
        <div className="overflow-x-auto">
          <table className="w-full text-sm">
            <thead>
              <tr className="border-b text-left text-muted-foreground">
                <th className="pb-3 font-medium">Sindicato</th>
                <th className="pb-3 font-medium">Associados</th>
                <th className="pb-3 font-medium">Plano</th>
                <th className="pb-3 font-medium">MRR</th>
                <th className="pb-3 font-medium">Status</th>
              </tr>
            </thead>
            <tbody>
              {d.tenants.map((t) => (
                <tr key={t.id} className="border-b border-border last:border-0">
                  <td className="py-3 font-medium text-card-foreground">{t.name}</td>
                  <td className="py-3 text-muted-foreground">{t.associados.toLocaleString("pt-BR")}</td>
                  <td className="py-3"><Badge variant="outline">{t.plano}</Badge></td>
                  <td className="py-3 text-muted-foreground">{t.mrr}</td>
                  <td className="py-3">
                    <Badge variant={t.status === "Ativo" ? "default" : "secondary"}>{t.status}</Badge>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </Card>
    </div>
  );
}
