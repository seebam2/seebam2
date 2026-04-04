import { StatCard } from "@/components/StatCard";
import { Card } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { CalendarCheck, Calendar, Star, Timer } from "lucide-react";
import { atendimentoData } from "@/data/seeders";
import {
  BarChart, Bar, XAxis, YAxis, CartesianGrid, Tooltip,
  ResponsiveContainer, PieChart, Pie, Cell,
} from "recharts";

const icons = [CalendarCheck, Calendar, Star, Timer];

const statusColors: Record<string, "default" | "secondary" | "destructive" | "outline"> = {
  "Concluído": "default",
  "Em atendimento": "secondary",
  "Aguardando": "outline",
};

export function DashboardAtendimento() {
  const d = atendimentoData;

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
          <h3 className="text-sm font-semibold text-card-foreground mb-4">Agenda de Hoje</h3>
          <div className="space-y-3">
            {d.agendamentosHoje.map((a) => (
              <div key={a.id} className="flex items-center justify-between py-2 border-b border-border last:border-0">
                <div className="flex items-center gap-4">
                  <span className="text-sm font-mono text-muted-foreground w-12">{a.horario}</span>
                  <div>
                    <p className="text-sm text-card-foreground font-medium">{a.name}</p>
                    <p className="text-xs text-muted-foreground">{a.servico}</p>
                  </div>
                </div>
                <Badge variant={statusColors[a.status] || "outline"}>{a.status}</Badge>
              </div>
            ))}
          </div>
        </Card>

        <div className="space-y-4">
          <Card className="p-5">
            <h3 className="text-sm font-semibold text-card-foreground mb-4">Demanda por Serviço</h3>
            <ResponsiveContainer width="100%" height={180}>
              <PieChart>
                <Pie data={d.servicosDemanda} cx="50%" cy="50%" innerRadius={40} outerRadius={70} dataKey="value" stroke="none">
                  {d.servicosDemanda.map((entry, i) => (
                    <Cell key={i} fill={entry.color} />
                  ))}
                </Pie>
                <Tooltip contentStyle={{ borderRadius: 8, fontSize: 12 }} />
              </PieChart>
            </ResponsiveContainer>
            <div className="grid grid-cols-2 gap-1 mt-2">
              {d.servicosDemanda.map((s) => (
                <div key={s.name} className="flex items-center gap-2">
                  <div className="h-2 w-2 rounded-full" style={{ backgroundColor: s.color }} />
                  <span className="text-xs text-muted-foreground">{s.name}</span>
                </div>
              ))}
            </div>
          </Card>

          <Card className="p-5">
            <h3 className="text-sm font-semibold text-card-foreground mb-3">Atendimentos na Semana</h3>
            <ResponsiveContainer width="100%" height={120}>
              <BarChart data={d.atendimentosSemana}>
                <XAxis dataKey="name" tick={{ fontSize: 11 }} stroke="hsl(var(--muted-foreground))" />
                <Tooltip contentStyle={{ borderRadius: 8, fontSize: 12 }} />
                <Bar dataKey="total" fill="hsl(var(--primary))" radius={[4, 4, 0, 0]} />
              </BarChart>
            </ResponsiveContainer>
          </Card>
        </div>
      </div>
    </div>
  );
}
