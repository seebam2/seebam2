import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import { AppLayout } from "@/components/AppLayout";
import { type UserRole } from "@/data/seeders";
import { DashboardSuperAdmin } from "@/components/dashboards/DashboardSuperAdmin";
import { DashboardGestor } from "@/components/dashboards/DashboardGestor";
import { DashboardFinanceiro } from "@/components/dashboards/DashboardFinanceiro";
import { DashboardAtendimento } from "@/components/dashboards/DashboardAtendimento";
import { DashboardAssociado } from "@/components/dashboards/DashboardAssociado";

const dashboards: Record<UserRole, React.ComponentType> = {
  super_admin: DashboardSuperAdmin,
  gestor: DashboardGestor,
  financeiro: DashboardFinanceiro,
  atendimento: DashboardAtendimento,
  associado: DashboardAssociado,
};

export default function Dashboard() {
  const navigate = useNavigate();
  const [role, setRole] = useState<UserRole | null>(null);

  useEffect(() => {
    const stored = sessionStorage.getItem("demo_role") as UserRole | null;
    if (!stored) {
      navigate("/login");
      return;
    }
    setRole(stored);
  }, [navigate]);

  if (!role) return null;

  const DashboardComponent = dashboards[role];

  return (
    <AppLayout title="Dashboard">
      <DashboardComponent />
    </AppLayout>
  );
}
