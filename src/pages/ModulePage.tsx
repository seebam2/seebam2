import { AppLayout } from "@/components/AppLayout";
import { Card } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Plus } from "lucide-react";

interface ModulePageProps {
  title: string;
  description: string;
  icon: React.ReactNode;
}

export default function ModulePage({ title, description, icon }: ModulePageProps) {
  return (
    <AppLayout title={title}>
      <div className="max-w-7xl space-y-6">
        <div className="flex items-center justify-between">
          <div>
            <h2 className="text-lg font-semibold text-foreground">{title}</h2>
            <p className="text-sm text-muted-foreground">{description}</p>
          </div>
          <Button size="sm" className="gap-2">
            <Plus className="h-4 w-4" />
            Novo
          </Button>
        </div>
        <Card className="flex flex-col items-center justify-center py-20 text-center">
          <div className="flex h-14 w-14 items-center justify-center rounded-xl bg-muted text-muted-foreground mb-4">
            {icon}
          </div>
          <h3 className="text-sm font-medium text-foreground mb-1">Módulo em construção</h3>
          <p className="text-xs text-muted-foreground max-w-sm">
            Este módulo será implementado em breve. Conecte sua API Laravel para começar a utilizá-lo.
          </p>
        </Card>
      </div>
    </AppLayout>
  );
}
