import { StatCard } from "@/components/StatCard";
import { Card } from "@/components/ui/card";
import { Users, UserPlus, Handshake, TrendingUp } from "lucide-react";
import { gestorData } from "@/data/seeders";
import {
  BarChart, Bar, XAxis, YAxis, CartesianGrid, Tooltip,
  ResponsiveContainer, PieChart, Pie, Cell, Legend,
} from "recharts";

const icons = [Users, UserPlus, Handshake, TrendingUp];

export function DashboardGestor() {
  const d = gestorData;

  return (
    <div className="space-y-6 max-w-7xl">
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {d.kpis.map((kpi, i) => {
          const Icon = icons[i];
          return <StatCard key={kpi.title} title={kpi.title} value={kpi.value} change={kpi.change} changeType={kpi.changeType} icon={<Icon className="h-5 w-5" />} />;
        })}
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <Card className="col-span-1 lg:col-span-2 p-5">
          <h3 className="text-sm font-semibold text-card-foreground mb-4">Crescimento Mensal</h3>
          <ResponsiveContainer width="100%" height={260}>
            <BarChart data={d.crescimentoMensal}>
              <CartesianGrid strokeDasharray="3 3" stroke="hsl(var(--border))" />
              <XAxis dataKey="name" tick={{ fontSize: 12 }} stroke="hsl(var(--muted-foreground))" />
              <YAxis tick={{ fontSize: 12 }} stroke="hsl(var(--muted-foreground))" />
              <Tooltip contentStyle={{ borderRadius: 8, fontSize: 12 }} />
              <Bar dataKey="novos" fill="hsl(142, 71%, 45%)" radius={[4, 4, 0, 0]} name="Novos" />
              <Bar dataKey="saidas" fill="hsl(0, 84%, 60%)" radius={[4, 4, 0, 0]} name="Saídas" />
              <Legend />
            </BarChart>
          </ResponsiveContainer>
        </Card>

        <Card className="p-5">
          <h3 className="text-sm font-semibold text-card-foreground mb-4">Associados por Status</h3>
          <ResponsiveContainer width="100%" height={200}>
            <PieChart>
              <Pie data={d.associadosPorStatus} cx="50%" cy="50%" innerRadius={50} outerRadius={80} dataKey="value" stroke="none">
                {d.associadosPorStatus.map((entry, i) => (
                  <Cell key={i} fill={entry.color} />
                ))}
              </Pie>
              <Tooltip contentStyle={{ borderRadius: 8, fontSize: 12 }} />
            </PieChart>
          </ResponsiveContainer>
          <div className="space-y-1 mt-2">
            {d.associadosPorStatus.map((s) => (
              <div key={s.name} className="flex items-center gap-2">
                <div className="h-2 w-2 rounded-full" style={{ backgroundColor: s.color }} />
                <span className="text-xs text-muted-foreground">{s.name}: {s.value.toLocaleString("pt-BR")}</span>
              </div>
            ))}
          </div>
        </Card>
      </div>

      <Card className="p-5">
        <h3 className="text-sm font-semibold text-card-foreground mb-4">Últimos Associados Cadastrados</h3>
        <div className="space-y-3">
          {d.ultimosAssociados.map((a) => (
            <div key={a.id} className="flex items-center justify-between py-2 border-b border-border last:border-0">
              <div>
                <p className="text-sm text-card-foreground font-medium">{a.name}</p>
                <p className="text-xs text-muted-foreground">{a.agencia}</p>
              </div>
              <span className="text-xs text-muted-foreground">{a.data}</span>
            </div>
          ))}
        </div>
      </Card>
    </div>
  );
}
