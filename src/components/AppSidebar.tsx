import {
  LayoutDashboard,
  Users,
  UserPlus,
  Building2,
  Landmark,
  Briefcase,
  DollarSign,
  CreditCard,
  HeartPulse,
  Handshake,
  BarChart3,
  Globe,
  UserCircle,
  Settings,
  ChevronDown,
} from "lucide-react";
import { NavLink } from "@/components/NavLink";
import { useLocation, useNavigate } from "react-router-dom";
import {
  Sidebar,
  SidebarContent,
  SidebarGroup,
  SidebarGroupContent,
  SidebarGroupLabel,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
  SidebarHeader,
  SidebarFooter,
  useSidebar,
} from "@/components/ui/sidebar";
import {
  Collapsible,
  CollapsibleContent,
  CollapsibleTrigger,
} from "@/components/ui/collapsible";

const mainItems = [
  { title: "Dashboard", url: "/dashboard", icon: LayoutDashboard },
];

const cadastroItems = [
  { title: "Associados", url: "/associados", icon: Users },
  { title: "Dependentes", url: "/dependentes", icon: UserPlus },
  { title: "Bancos", url: "/bancos", icon: Landmark },
  { title: "Agências", url: "/agencias", icon: Building2 },
  { title: "Histórico Profissional", url: "/historico", icon: Briefcase },
];

const financeiroItems = [
  { title: "Mensalidades", url: "/mensalidades", icon: DollarSign },
  { title: "Pagamentos", url: "/pagamentos", icon: CreditCard },
];

const servicosItems = [
  { title: "Serviços", url: "/servicos", icon: HeartPulse },
  { title: "Convênios", url: "/convenios", icon: Handshake },
];

const sistemaItems = [
  { title: "Relatórios", url: "/relatorios", icon: BarChart3 },
  { title: "CMS", url: "/cms", icon: Globe },
  { title: "Portal do Associado", url: "/portal", icon: UserCircle },
  { title: "Configurações", url: "/configuracoes", icon: Settings },
];

interface NavGroupProps {
  label: string;
  items: { title: string; url: string; icon: React.ElementType }[];
  collapsed: boolean;
}

function NavGroup({ label, items, collapsed }: NavGroupProps) {
  const location = useLocation();
  const isActive = items.some((i) => location.pathname === i.url);

  return (
    <Collapsible defaultOpen={isActive || true}>
      <SidebarGroup>
        {!collapsed && (
          <CollapsibleTrigger asChild>
            <SidebarGroupLabel className="cursor-pointer flex items-center justify-between text-[11px] font-semibold uppercase tracking-wider text-sidebar-muted hover:text-sidebar-foreground transition-colors">
              {label}
              <ChevronDown className="h-3 w-3" />
            </SidebarGroupLabel>
          </CollapsibleTrigger>
        )}
        <CollapsibleContent>
          <SidebarGroupContent>
            <SidebarMenu>
              {items.map((item) => (
                <SidebarMenuItem key={item.title}>
                  <SidebarMenuButton asChild>
                    <NavLink
                      to={item.url}
                      end={item.url === "/"}
                      className="flex items-center gap-3 rounded-md px-3 py-2 text-sm text-sidebar-foreground hover:bg-sidebar-accent transition-colors"
                      activeClassName="bg-sidebar-accent text-sidebar-accent-foreground font-medium"
                    >
                      <item.icon className="h-4 w-4 shrink-0" />
                      {!collapsed && <span>{item.title}</span>}
                    </NavLink>
                  </SidebarMenuButton>
                </SidebarMenuItem>
              ))}
            </SidebarMenu>
          </SidebarGroupContent>
        </CollapsibleContent>
      </SidebarGroup>
    </Collapsible>
  );
}

export function AppSidebar() {
  const { state } = useSidebar();
  const collapsed = state === "collapsed";
  const navigate = useNavigate();

  const handleLogout = () => {
    sessionStorage.removeItem("demo_role");
    navigate("/");
  };

  // Get current role info
  const role = sessionStorage.getItem("demo_role") || "gestor";
  const roleLabels: Record<string, string> = {
    super_admin: "Super Admin",
    gestor: "Gestor",
    financeiro: "Financeiro",
    atendimento: "Atendimento",
    associado: "Associado",
  };
  const roleNames: Record<string, string> = {
    super_admin: "Ricardo M.",
    gestor: "Fernanda O.",
    financeiro: "Paulo N.",
    atendimento: "Carla R.",
    associado: "José A.",
  };
  const initials: Record<string, string> = {
    super_admin: "RM",
    gestor: "FO",
    financeiro: "PN",
    atendimento: "CR",
    associado: "JA",
  };

  return (
    <Sidebar collapsible="icon" className="border-r border-sidebar-border">
      <SidebarHeader className="px-4 py-5">
        <div className="flex items-center gap-3">
          <div className="flex h-8 w-8 items-center justify-center rounded-lg gradient-primary">
            <Landmark className="h-4 w-4 text-primary-foreground" />
          </div>
          {!collapsed && (
            <div>
              <h2 className="text-sm font-semibold text-foreground">Seebam</h2>
              <p className="text-[11px] text-muted-foreground">Gestão Sindical</p>
            </div>
          )}
        </div>
      </SidebarHeader>

      <SidebarContent className="px-2">
        <SidebarGroup>
          <SidebarGroupContent>
            <SidebarMenu>
              {mainItems.map((item) => (
                <SidebarMenuItem key={item.title}>
                  <SidebarMenuButton asChild>
                    <NavLink
                      to={item.url}
                      end
                      className="flex items-center gap-3 rounded-md px-3 py-2 text-sm text-sidebar-foreground hover:bg-sidebar-accent transition-colors"
                      activeClassName="bg-sidebar-accent text-sidebar-accent-foreground font-medium"
                    >
                      <item.icon className="h-4 w-4 shrink-0" />
                      {!collapsed && <span>{item.title}</span>}
                    </NavLink>
                  </SidebarMenuButton>
                </SidebarMenuItem>
              ))}
            </SidebarMenu>
          </SidebarGroupContent>
        </SidebarGroup>

        <NavGroup label="Cadastros" items={cadastroItems} collapsed={collapsed} />
        <NavGroup label="Financeiro" items={financeiroItems} collapsed={collapsed} />
        <NavGroup label="Serviços" items={servicosItems} collapsed={collapsed} />
        <NavGroup label="Sistema" items={sistemaItems} collapsed={collapsed} />
      </SidebarContent>

      <SidebarFooter className="px-4 py-3 border-t border-sidebar-border">
        {!collapsed && (
          <div className="flex items-center gap-3">
            <div className="h-8 w-8 rounded-full bg-muted flex items-center justify-center">
              <span className="text-xs font-medium text-muted-foreground">{initials[role] || "AD"}</span>
            </div>
            <div className="flex-1 min-w-0">
              <p className="text-sm font-medium text-foreground truncate">{roleNames[role] || "Admin"}</p>
              <p className="text-[11px] text-muted-foreground truncate">{roleLabels[role] || "Gestor"}</p>
            </div>
            <button onClick={handleLogout} className="text-xs text-muted-foreground hover:text-foreground transition-colors" title="Sair">
              ✕
            </button>
          </div>
        )}
      </SidebarFooter>
    </Sidebar>
  );
}
