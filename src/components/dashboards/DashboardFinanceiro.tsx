import { StatCard } from "@/components/StatCard";
import { Card } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { DollarSign, AlertTriangle, Clock, TrendingDown } from "lucide-react";
import { financeiroData } from "@/data/seeders";
import {
  BarChart, Bar, XAxis, YAxis, CartesianGrid, Tooltip,
  ResponsiveContainer, Legend,
} from "recharts";

const icons = [DollarSign, AlertTriangle, Clock, TrendingDown];

export function DashboardFinanceiro() {
  const d = financeiroData;

  return (
    <div className="space-y-6 max-w-7xl">
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {d.kpis.map((kpi, i) => {
          const Icon = icons[i];
          return <StatCard key={kpi.title} title={kpi.title} value={kpi.value} change={kpi.change} changeType={kpi.changeType} icon={<Icon className="h-5 w-5" />} />;
        })}
      </div>

      <Card className="p-5">
        <h3 className="text-sm font-semibold text-card-foreground mb-4">Receita vs Despesas</h3>
        <ResponsiveContainer width="100%" height={280}>
          <BarChart data={d.receitaChart}>
            <CartesianGrid strokeDasharray="3 3" stroke="hsl(var(--border))" />
            <XAxis dataKey="name" tick={{ fontSize: 12 }} stroke="hsl(var(--muted-foreground))" />
            <YAxis tick={{ fontSize: 12 }} stroke="hsl(var(--muted-foreground))" />
            <Tooltip formatter={(value: number) => [`R$ ${value.toLocaleString("pt-BR")}`]} contentStyle={{ borderRadius: 8, fontSize: 12 }} />
            <Bar dataKey="receita" fill="hsl(var(--primary))" radius={[4, 4, 0, 0]} name="Receita" />
            <Bar dataKey="despesa" fill="hsl(0, 84%, 60%)" radius={[4, 4, 0, 0]} name="Despesas" />
            <Legend />
          </BarChart>
        </ResponsiveContainer>
      </Card>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <Card className="p-5">
          <div className="flex items-center justify-between mb-4">
            <h3 className="text-sm font-semibold text-card-foreground">Inadimplentes</h3>
            <Badge variant="destructive" className="text-[10px]">Atenção</Badge>
          </div>
          <div className="space-y-3">
            {d.inadimplentes.map((item) => (
              <div key={item.id} className="flex items-center justify-between py-2 border-b border-border last:border-0">
                <div>
                  <p className="text-sm text-card-foreground">{item.name}</p>
                  <p className="text-xs text-muted-foreground">{item.agencia} • {item.meses} meses</p>
                </div>
                <span className="text-sm font-medium text-destructive">{item.valor}</span>
              </div>
            ))}
          </div>
        </Card>

        <Card className="p-5">
          <h3 className="text-sm font-semibold text-card-foreground mb-4">Pagamentos Recentes</h3>
          <div className="space-y-3">
            {d.pagamentosRecentes.map((p) => (
              <div key={p.id} className="flex items-center justify-between py-2 border-b border-border last:border-0">
                <div>
                  <p className="text-sm text-card-foreground">{p.name}</p>
                  <p className="text-xs text-muted-foreground">{p.tipo} • {p.data}</p>
                </div>
                <div className="text-right">
                  <p className="text-sm font-medium text-card-foreground">{p.valor}</p>
                  <Badge variant={p.status === "Confirmado" ? "default" : "secondary"} className="text-[10px]">{p.status}</Badge>
                </div>
              </div>
            ))}
          </div>
        </Card>
      </div>
    </div>
  );
}
