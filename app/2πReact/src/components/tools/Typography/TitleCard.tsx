import { Typography, TypographyProps, useMediaQuery, useTheme } from '@mui/material';

const TitleCard: React.FC<TypographyProps> = (props) => {
  const theme = useTheme();
  const isLargeScreen = useMediaQuery(theme.breakpoints.up('sm'));
  const variant = isLargeScreen ? 'h5' : 'h6';

  return (
    <Typography 
      {...props} 
      variant={props.variant || variant} 
    />
  );
};

export default TitleCard;